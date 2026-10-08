<?php
// Shared records table. Needs: $obj, $records, $showActions
$listFields = $obj->getFieldList();
?>
<div class="table-scroll">
    <table>
        <tr>
            <?php foreach ($listFields as $field): ?>
                <th><?php echo htmlspecialchars($field["label"]); ?></th>
            <?php endforeach; ?>

            <?php if ($showActions): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>

        <?php if ($records && mysqli_num_rows($records) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($records)): ?>
                <tr>
                    <?php foreach ($listFields as $field): ?>
                        <td><?php echo $obj->formatValue($field, $row[$field["name"]]); ?></td>
                    <?php endforeach; ?>

                    <?php if ($showActions): ?>
                        <td class="actions">
                            <a href="form.php?id=<?php echo $row["id"]; ?>" class="edit" title="Edit" aria-label="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <a href="manage.php?delete=<?php echo $row["id"]; ?>" class="delete" title="Delete" aria-label="Delete"
                                onclick="return confirm('Delete this record?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="<?php echo count($listFields) + 1; ?>" class="empty">No records found.</td>
            </tr>

        <?php endif; ?>
    </table>
</div>
