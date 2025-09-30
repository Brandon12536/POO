-- Crear tabla employees en Supabase
-- Ejecutar este script en el SQL Editor de Supabase

CREATE TABLE IF NOT EXISTS employees (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INTEGER NOT NULL CHECK (age >= 18 AND age <= 65),
    email VARCHAR(255) NOT NULL UNIQUE,
    position VARCHAR(255) NOT NULL,
    salary DECIMAL(10,2) NOT NULL CHECK (salary > 0),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Crear índices para mejor rendimiento
CREATE INDEX IF NOT EXISTS idx_employees_email ON employees(email);
CREATE INDEX IF NOT EXISTS idx_employees_position ON employees(position);
CREATE INDEX IF NOT EXISTS idx_employees_salary ON employees(salary);

-- Insertar datos de ejemplo
INSERT INTO employees (name, age, email, position, salary) VALUES
('Ana García', 28, 'ana.garcia@empresa.com', 'Desarrolladora Senior', 75000.00),
('Carlos Rodríguez', 35, 'carlos.rodriguez@empresa.com', 'Gerente de Ventas', 85000.00),
('María López', 29, 'maria.lopez@empresa.com', 'Analista de Datos', 65000.00),
('Luis Martínez', 32, 'luis.martinez@empresa.com', 'Arquitecto de Software', 95000.00),
('Sofía Hernández', 27, 'sofia.hernandez@empresa.com', 'Diseñadora UX', 70000.00)
ON CONFLICT (email) DO NOTHING;

-- Habilitar Row Level Security (RLS)
ALTER TABLE employees ENABLE ROW LEVEL SECURITY;

-- Crear política para permitir todas las operaciones (para desarrollo)
-- En producción, deberías crear políticas más restrictivas
CREATE POLICY "Enable all operations for employees" ON employees
    FOR ALL USING (true) WITH CHECK (true);

-- Función para actualizar updated_at automáticamente
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Trigger para actualizar updated_at
CREATE TRIGGER update_employees_updated_at 
    BEFORE UPDATE ON employees 
    FOR EACH ROW 
    EXECUTE FUNCTION update_updated_at_column();
