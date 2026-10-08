-- Blog CMS database
CREATE DATABASE IF NOT EXISTS blog_cms;
USE blog_cms;

CREATE TABLE IF NOT EXISTS admins (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- demo login: admin / admin123
INSERT INTO admins (username, password) VALUES ('admin', '$2y$12$HCGUZtUOwIB6zIFzOFesFuNtdmS8UMYPwKER2b6emX7cmoV9Sgoa.');

CREATE TABLE IF NOT EXISTS posts (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    title              VARCHAR(150) NOT NULL,
    author             VARCHAR(150) NOT NULL,
    category           VARCHAR(50) NOT NULL,
    status             VARCHAR(50) NOT NULL,
    content            TEXT NOT NULL,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO posts (title, author, category, status, content) VALUES
    ('Nifty 50 Explained: How India''s Benchmark Index Works', 'Admin', 'Markets', 'Published', 'The Nifty 50 tracks the 50 largest companies listed on the NSE, weighted by free-float market capitalisation.\n\nSectors such as banking, IT and energy carry the heaviest weights.'),
    ('Sensex vs Nifty: What Is the Difference?', 'Admin', 'Markets', 'Published', 'The Sensex has 30 companies listed on the BSE, while the Nifty 50 covers 50 companies on the NSE.\n\nBoth move closely together on most days.'),
    ('SIP vs Lump Sum: Investing in Indian Mutual Funds', 'Admin', 'Investing', 'Published', 'A SIP spreads your money across months and reduces timing risk.\n\nStart with a small monthly amount and increase it every year.'),
    ('How to Read a Stock Quote on NSE', 'Admin', 'Learning', 'Published', 'LTP, open, high, low and volume tell you how a share traded today.\n\nAlways compare volume with the recent average.'),
    ('RBI Policy Week Preview (draft)', 'Admin', 'Markets', 'Draft', 'Outline coming soon.');
