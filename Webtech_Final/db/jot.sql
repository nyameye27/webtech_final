

-- Create Mood table
CREATE TABLE Mood (
    mood_id INT PRIMARY KEY AUTO_INCREMENT,
    mood_name VARCHAR(50) NOT NULL,
    mood_icon VARCHAR(10) DEFAULT NULL  -- Optional: stores an emoji or icon representation
);

-- Create User table
CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    preferences JSON DEFAULT '{}'  -- Removed extra comma
    userrole enum('regular','admin') DEFAULT 'regular'
);

-- Create Tags table
CREATE TABLE Tags (
    tag_id INT PRIMARY KEY AUTO_INCREMENT,
    tag_name VARCHAR(50) UNIQUE NOT NULL
);

-- Create Entries table
CREATE TABLE Entries (
    entry_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    mood_id INT,
    tags JSON DEFAULT '[]',  -- Adjusted position for clarity
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (mood_id) REFERENCES Mood(mood_id) ON DELETE SET NULL
);

-- Create EntryTags table for many-to-many relationship between Entries and Tags
CREATE TABLE EntryTags (
    entry_tag_id INT PRIMARY KEY AUTO_INCREMENT,
    entry_id INT,
    tag_id INT, 
    FOREIGN KEY (entry_id) REFERENCES Entries(entry_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tags(tag_id) ON DELETE CASCADE
);

-- System Configuration Table
CREATE TABLE system_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(100) DEFAULT 'Mindful Journal',
    default_role ENUM('user', 'admin') DEFAULT 'user',
    maintenance_mode ENUM('on', 'off') DEFAULT 'off',
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert initial configuration
INSERT INTO system_config (site_name, default_role, maintenance_mode) 
VALUES ('Mindful Journal', 'user', 'off');
