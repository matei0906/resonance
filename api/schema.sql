-- Minimal schema for users table
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX (email)
);

-- Example insert (password: password123)
-- INSERT INTO users (name, email, password_hash) VALUES (
--   'Test User', 'test@rpi.edu', '$2y$10$8hXi4oYI8mVQ4aQqk5nQ2O9t0m6M0m7Z2h7Jj3JHq7kq6J3xS9J6.'
-- );


