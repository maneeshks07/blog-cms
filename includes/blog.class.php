<?php

class Blog 
    {
        var $conn;
        var $errorMessage;
        var $fields;
        var $listFields;

        function __construct($conn) 
            {
                $this->conn         = $conn;
                $this->errorMessage = "";

                $this->fields = array(
            array("name" => "title", "label" => "Title", "type" => "text", "required" => true),
            array("name" => "author", "label" => "Author", "type" => "text", "required" => true),
            array("name" => "category", "label" => "Category", "type" => "select", "required" => true, "options" => array("Tech", "Business", "Lifestyle", "Travel")),
            array("name" => "status", "label" => "Status", "type" => "select", "required" => true, "options" => array("Draft", "Published"), "format" => "badge", "default" => "Draft"),
            array("name" => "content", "label" => "Content", "type" => "textarea", "required" => true)
                );

                $this->listFields = array("title", "author", "category", "status");
            }

        function login($username, $password) 
            {
                $stmt = mysqli_prepare($this->conn, "SELECT username, password FROM admins WHERE username = ?");
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $row    = mysqli_fetch_assoc($result);

                if ($row && password_verify($password, $row["password"])) 
                    {
                        $_SESSION["username"] = $row["username"];
                        return true;
                    } 
                else 
                    {
                        $this->errorMessage = "Invalid username or password.";
                        return false;
                    }
            }

        function getCount($sql) 
            {
                $result = mysqli_query($this->conn, $sql);
                $row    = mysqli_fetch_assoc($result);
                return $row["total"];
            }

        function getFieldList() 
            {
                $list = array();

                foreach ($this->fields as $field) 
                    {
                        if (in_array($field["name"], $this->listFields)) 
                            {
                                $list[] = $field;
                            }
                    }

                return $list;
            }

        function search($keyword, $filter, $limit = 0) 
            {
                $sql    = "SELECT * FROM posts WHERE 1";
                $types  = "";
                $params = array();

                if ($keyword != "") 
                    {
                        $sql .= " AND (title LIKE ? OR author LIKE ?)";

                        for ($i = 0; $i < 2; $i++) 
                            {
                                $types   .= "s";
                                $params[] = "%" . $keyword . "%";
                            }
                    }

                if ($filter != "") 
                    {
                        $sql     .= " AND status = ?";
                        $types   .= "s";
                        $params[] = $filter;
                    }

                $sql .= " ORDER BY id DESC";

                if ($limit > 0) 
                    {
                        $sql .= " LIMIT " . (int) $limit;
                    }

                $stmt = mysqli_prepare($this->conn, $sql);

                if ($types != "") 
                    {
                        mysqli_stmt_bind_param($stmt, $types, ...$params);
                    }

                mysqli_stmt_execute($stmt);
                return mysqli_stmt_get_result($stmt);
            }

        function searchPublished($keyword, $category) 
            {
                $sql    = "SELECT * FROM posts WHERE status = 'Published' AND (title LIKE ? OR content LIKE ?)";
                $types  = "ss";
                $params = array("%" . $keyword . "%", "%" . $keyword . "%");

                if ($category != "") 
                    {
                        $sql     .= " AND category = ?";
                        $types   .= "s";
                        $params[] = $category;
                    }

                $sql .= " ORDER BY id DESC";

                $stmt = mysqli_prepare($this->conn, $sql);
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                mysqli_stmt_execute($stmt);
                return mysqli_stmt_get_result($stmt);
            }

        function getById($id) 
            {
                $stmt = mysqli_prepare($this->conn, "SELECT * FROM posts WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                return mysqli_fetch_assoc($result);
            }

        function validate($data) 
            {
                foreach ($this->fields as $field) 
                    {
                        $value = trim($data[$field["name"]] ?? "");

                        if ($field["required"] && $value === "") 
                            {
                                return $field["label"] . " is required.";
                            }

                        if ($value !== "" && $field["type"] == "number" && !is_numeric($value)) 
                            {
                                return $field["label"] . " must be a number.";
                            }

                        if ($value !== "" && $field["type"] == "number" && $value < 0) 
                            {
                                return $field["label"] . " cannot be negative.";
                            }

                        if ($value !== "" && $field["type"] == "date" && !strtotime($value)) 
                            {
                                return $field["label"] . " is not a valid date.";
                            }

                        if ($value !== "" && $field["type"] == "select" && !in_array($value, $field["options"])) 
                            {
                                return $field["label"] . " is not valid.";
                            }
                    }

                return "";
            }

        function saveRecord($id, $data) 
            {
                $error = $this->validate($data);

                if ($error != "") 
                    {
                        $this->errorMessage = $error;
                        return false;
                    }

                $names  = array();
                $values = array();

                foreach ($this->fields as $field) 
                    {
                        $names[]  = $field["name"];
                        $values[] = trim($data[$field["name"]] ?? "");
                    }

                $types = str_repeat("s", count($names));

                if ($id > 0) 
                    {
                        $sql      = "UPDATE posts SET " . implode(" = ?, ", $names) . " = ? WHERE id = ?";
                        $types   .= "i";
                        $values[] = $id;
                    } 
                else 
                    {
                        $marks = implode(", ", array_fill(0, count($names), "?"));
                        $sql   = "INSERT INTO posts (" . implode(", ", $names) . ") VALUES ($marks)";
                    }

                try 
                    {
                        $stmt = mysqli_prepare($this->conn, $sql);
                        mysqli_stmt_bind_param($stmt, $types, ...$values);
                        mysqli_stmt_execute($stmt);
                        return true;
                    } 
                catch (Exception $e) 
                    {
                        $this->errorMessage = "Could not save. A unique value may already exist.";
                        return false;
                    }
            }

        function deleteRecord($id) 
            {
                $stmt = mysqli_prepare($this->conn, "DELETE FROM posts WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                return mysqli_stmt_execute($stmt);
            }

        function formatValue($field, $value) 
            {
                if ($value === null || $value === "") 
                    {
                        return "-";
                    }

                if ($field["type"] == "date") 
                    {
                        return date("d M Y", strtotime($value));
                    }

                if ($field["type"] == "time") 
                    {
                        return date("h:i A", strtotime($value));
                    }

                if (($field["format"] ?? "") == "money") 
                    {
                        return "$" . number_format($value, 2);
                    }

                if (($field["format"] ?? "") == "badge") 
                    {
                        return '<span class="badge badge-' . strtolower(htmlspecialchars($value)) . '">' . htmlspecialchars($value) . '</span>';
                    }

                return htmlspecialchars($value);
            }
    }

?>
