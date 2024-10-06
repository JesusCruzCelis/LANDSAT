CREATE DATA BASE landsatBD

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255) NOT NULL,
    num NUMERIC(10, 0),
    pass_hash TEXT NOT NULL,
    longitud NUMERIC(12, 8),
    latitud NUMERIC(12, 8),
    hora_inicio TIME,
    hora_fin TIME,
    pref_noti VARCHAR(255),
    CONSTRAINT users_email_key UNIQUE (email),
    CONSTRAINT email_valido CHECK (email ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$')
);
