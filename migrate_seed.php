<?php
$pdo = require __DIR__ . '/db.php';

$pdo->exec("
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  email TEXT UNIQUE NOT NULL,
  full_name TEXT NOT NULL,
  password_hash TEXT NOT NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE IF NOT EXISTS products (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  price NUMERIC(12,2) NOT NULL CHECK (price >= 0),
  stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
  created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);
");

$pdo->exec("
INSERT INTO users (email, full_name, password_hash) VALUES
('admin@lasxd.local', 'Admin', 'demo_hash_admin'),
('user1@lasxd.local', 'User One', 'demo_hash_user1'),
('user2@lasxd.local', 'User Two', 'demo_hash_user2')
ON CONFLICT (email) DO NOTHING;
");

$pdo->exec("
INSERT INTO products (name, price, stock) VALUES
('Cement 50kg', 95000, 120),
('Steel bar D10', 16500, 800),
('Sand (m3)', 220000, 50),
('Brick (100 pcs)', 120000, 40);
");

echo "Done: migrated + seeded\n";