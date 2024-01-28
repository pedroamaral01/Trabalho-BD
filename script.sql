DROP TABLE IF EXISTS Cliente CASCADE;

CREATE TABLE Cliente (
	cpf						VARCHAR(15),
	nome					VARCHAR(45) NOT NULL,
	telefone				VARCHAR(11) NOT NULL,
	estado					VARCHAR(2)  NOT NULL,
	cidade					VARCHAR(30) NOT NULL,
	endereco				VARCHAR(80) NOT NULL,
	PRIMARY KEY(cpf)
);

INSERT INTO Cliente (cpf, nome, telefone, estado, cidade, endereco)
VALUES 
	('123.456.789-01', 'João Silva', '31987654321', 'MG', 'Belo Horizonte', 'Rua A, 123'),
	('987.654.321-09', 'Maria Oliveira', '21999888777', 'RJ', 'Rio de Janeiro', 'Avenida B, 456'),
	('111.222.333-44', 'Pedro Santos', '44111222333', 'SP', 'Araras', 'Rua C, 789'),
	('555.666.777-88', 'Ana Pereira', '86555666777', 'SP', 'São Paulo', 'Avenida D, 1011'),
	('999.999.999-99', 'Bruno', '99999999999', 'MG', 'João Monlevade', 'Rua 36, 115');
	
DROP TABLE IF EXISTS Dependente CASCADE;

CREATE TABLE Dependente (
	cpf_cliente				VARCHAR(15),
	nome					VARCHAR(45) NOT NULL,
	parentesco				VARCHAR(20) NOT NULL,
	endereco				VARCHAR(80) NOT NULL,
	FOREIGN KEY (cpf_cliente) REFERENCES Cliente(cpf),
	PRIMARY KEY (nome, cpf_cliente)
);

INSERT INTO Dependente (cpf_cliente, nome, parentesco, endereco)
VALUES 
	('123.456.789-01', 'Cecília Conceição', 'Avó', 'Rua X, 456'),
	('987.654.321-09', 'Maria Filha', 'Filha', 'Avenida Y, 789'),
	('111.222.333-44', 'Pedro Junior', 'Filho', 'Rua Z, 1011'),
	('555.666.777-88', 'Natalina', 'Enteada', 'Avenida W, 1213');
	
DROP TABLE IF EXISTS Emprestimo CASCADE;

CREATE TABLE Emprestimo (
	codigo					SERIAL,
	juros					FLOAT NOT NULL,
	valor_i					FLOAT NOT NULL,
	valor_f					FLOAT NOT NULL,
	nPrestacoes				INT NOT NULL,
	tipo                                    VARCHAR(14) NOT NULL,
	valor_prestacoes			FLOAT NOT NULL,
	PRIMARY KEY (codigo)
);

INSERT INTO Emprestimo (juros, valor_i, valor_f, nPrestacoes, tipo, valor_prestacoes)
VALUES 
	(0.08, 2000.00, 7992.04, 18, 'PESSOAL', 444.00),
	(0.03, 1500.00, 1791.08, 6, 'PESSOAL', 298.51),
	(0.08, 2000.00, 7992.04, 18, 'PESSOAL', 444.00),
	(0.03, 1500.00, 1791.08, 6, 'PESSOAL', 298.51),
	(0.08, 15000.00, 59940.29, 18, 'PESSOAL', 3330.01),
	(0.06, 1200.00, 1912.62, 8, 'COMPARTILHADO', 239.07),
	(0.01, 99999.99, 267803.32, 99, 'COMPARTILHADO', 2705.08);

DROP TABLE IF EXISTS Faz CASCADE;

CREATE TABLE Faz (
	codigo					INT NOT NULL,
	cpf_cliente				VARCHAR(15) NOT NULL,
	FOREIGN KEY (cpf_cliente) REFERENCES Cliente(cpf),
	FOREIGN KEY (codigo) REFERENCES Emprestimo(codigo),
	PRIMARY KEY (cpf_cliente,codigo)
);

INSERT INTO Faz (codigo, cpf_cliente)
VALUES
	(6, '123.456.789-01'),
	(6, '987.654.321-09'),
	(7, '111.222.333-44'),
	(7, '555.666.777-88'),
	(1, '123.456.789-01'),
	(2, '987.654.321-09'),
	(3, '111.222.333-44'),
	(4, '555.666.777-88'),
	(5, '999.999.999-99');
