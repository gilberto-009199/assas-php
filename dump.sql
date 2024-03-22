CREATE TABLE IF NOT EXISTS tbl_clientes(
    id int primary key auto_increment,

    nomeRazaoSocial varchar(255) not null,
    cpfCnpj varchar(255) not null,
    email  varchar(255) not null,
    inscricaoEstadual varchar(255) not null,
    telefoneCelular varchar(255) not null,
    cep varchar(255) not null,
    cidade varchar(255) not null,
    endereco text(600) not null,

    assasClienteId varchar(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tbl_vendas(
    id int primary key auto_increment,

    produto varchar(100) not null,
    tipoPagamento varchar(100) not null,
    preco decimal(5, 2) not null,
    vencimento TIMESTAMP not null,

    status varchar(100),

    assasCobrancaId varchar(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    idClientes INT not null,
    FOREIGN KEY (idClientes) REFERENCES tbl_clientes(id)
);

CREATE TABLE IF NOT EXISTS tbl_vendas_status(
    id int primary key auto_increment,

    status varchar(100) not null,
    info json not null,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    idVendas INT,
    FOREIGN KEY (idVendas) REFERENCES tbl_vendas(id),

    idClientes INT not null,
    FOREIGN KEY (idClientes) REFERENCES tbl_clientes(id)
);

CREATE TABLE IF NOT EXISTS tbl_licensas(
    id int primary key auto_increment,

    status varchar(100) not null default 'NAO_ATRIBUIDO',
    mac     varchar(255),

    lastUse TIMESTAMP,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    idVendas INT,
    FOREIGN KEY (idVendas) REFERENCES tbl_vendas(id),

    idClientes INT not null,
    FOREIGN KEY (idClientes) REFERENCES tbl_clientes(id)
);

CREATE TABLE IF NOT EXISTS tbl_licensas_jornal(
    id int primary key auto_increment,

    act     varchar(255) not null,
    ip      varchar(255) not null,
    mac     varchar(255) not null,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    idLicensas INT,
    FOREIGN KEY (idLicensas) REFERENCES tbl_licensas(id)
);