CREATE TABLE pessoa(
    cpf VARCHAR2(11) NOT NULL,
    tipopessoa VARCHAR2(20),
    datanascimento DATE,
    nome VARCHAR2(50),
    cep VARCHAR2(8),
    bairro VARCHAR2(30),
    numero NUMBER,
    rua VARCHAR2(20)
);

CREATE TABLE telefonepessoa(
  cpfpessoa VARCHAR2(11) NOT NULL,
  telefone VARCHAR2(11) NOT NULL
);

CREATE TABLE integrante(
    cpfpessoa VARCHAR2(11) NOT NULL
);

CREATE TABLE espectador(
    cpfpessoa VARCHAR2(11) NOT NULL,
    codigo NUMBER NOT NULL
);

CREATE TABLE funcionario(
    cpfpessoa VARCHAR2(11) NOT NULL,
    numeroregistro NUMBER NOT NULL UNIQUE,
    tipofuncionario CHAR(3),
    cargo VARCHAR2(10)
);

CREATE TABLE turnofuncionario(
    cpffuncionario VARCHAR2(11) NOT NULL,
    horainicio VARCHAR2(10) NOT NULL,
    data DATE,
    horafim VARCHAR2(10) NOT NULL
);

CREATE TABLE webmaster(
    cpffuncionario VARCHAR2(11) NOT NULL,
    email VARCHAR2(50) NOT NULL UNIQUE
);

CREATE TABLE servico(
    cnpj VARCHAR2(11) NOT NULL,
    tiposervico VARCHAR2(50)
);

CREATE TABLE telefoneservico(
    cnpjservico VARCHAR(14) NOT NULL,
    telefone VARCHAR(11) NOT NULL
);

CREATE TABLE seguranca(
    cnpjservico VARCHAR2(14) NOT NULL,
    nome VARCHAR2(50)
);


CREATE TABLE profissionalseg(
    cpffuncionario VARCHAR2(11) NOT NULL,
    nrocredencial NUMBER NOT NULL UNIQUE,
    localizacao VARCHAR2(50),
    cnpjseguranca VARCHAR2(14)
);

CREATE TABLE ambulatorio(
    cnpjservico VARCHAR2(14) NOT NULL,
    capacidade NUMBER,
    nome VARCHAR2(50)
);

CREATE TABLE medico(
    cpffuncionario VARCHAR2(11) NOT NULL,
    crm NUMBER NOT NULL UNIQUE,
    cnpjambulatorio VARCHAR2(14)
);

CREATE TABLE atendimento(
    cpfpessoa VARCHAR2(11) NOT NULL,
    cpfmedico VARCHAR2(11) NOT NULL,
    data DATE NOT NULL,
    descricao VARCHAR2(250)
);

CREATE TABLE ocorrencia(
    numero NUMBER NOT NULL,
    data DATE,
    descricao VARCHAR2(50),
    cpfprofissionalseg VARCHAR2(11),
    longitude NUMBER,
    latitude NUMBER
);

CREATE TABLE ocorrenciapessoa(
    cpfpessoa VARCHAR2(11) NOT NULL,
    numeroocorencia NUMBER NOT NULL
);

CREATE TABLE lineup(
    data DATE NOT NULL, 
    capacidade NUMBER
);

CREATE TABLE local(
    nome VARCHAR2(50) NOT NULL
);

CREATE TABLE show(
    nomelocal VARCHAR2(50) NOT NULL,
    datalineup DATE,
    horainicio VARCHAR2(10)
);

CREATE TABLE banda(
    nome VARCHAR2(50) NOT NULL,
    historia VARCHAR2(250),
    site VARCHAR2(100),
    ordemapresentacao NUMBER,
    nomelocalshow VARCHAR2(50),
    datalineupshow DATE,
    horainicioshow VARCHAR2(10)
);

CREATE TABLE integrantebanda(
    nomebanda VARCHAR2(50) NOT NULL,
    cpfintegrante VARCHAR2(11) NOT NULL,
    historia VARCHAR2(200),
    datainicio DATE,
    funcao VARCHAR2(50)
);

CREATE TABLE ingresso(
    numero NUMBER,
    valor NUMBER,
    lineupentrada DATE,
    horaentrada VARCHAR2(10),
    cpfespectador VARCHAR2(11) NOT NULL,
    pertencedatalineup DATE
);

CREATE TABLE blog(
    url VARCHAR2(50) NOT NULL,
    datacriacao DATE,
    nome VARCHAR2(20),
    datalineup DATE NOT NULL
);

CREATE TABLE post(
    id NUMBER NOT NULL,
    texto VARCHAR2(250),
    datacriacao DATE,
    urlblog VARCHAR2(100),
    cpfwebmaster VARCHAR2(11)
);

CREATE TABLE comentario(
    id NUMBER NOT NULL,
    autor VARCHAR2(50),
    email VARCHAR2(250),
    datacriacao DATE,
    texto VARCHAR2(250),
    idpost NUMBER,
    idresposta NUMBER
);

CREATE TABLE restaurante(
    cnpj VARCHAR2(14) NOT NULL,
    nome VARCHAR2(50),
    especialidade VARCHAR2(10),
    cep VARCHAR2(8),
    bairro VARCHAR2(50),
    numero NUMBER,
    rua VARCHAR2(20),
    latitude NUMBER,
    longitude NUMBER
);

CREATE TABLE horariofunrest(
    cnpjrestaurante VARCHAR2(14) NOT NULL,
    horainicio VARCHAR2(10),
    horafim VARCHAR2(10),
    diasemana VARCHAR2(15)
);

CREATE TABLE hospedagem(
    cnpj VARCHAR2(14) NOT NULL,
    nome VARCHAR2(50),
    capacidade NUMBER,
    tipohospedagem VARCHAR2(20),
    latitude NUMBER,
    longitude NUMBER,
    rua VARCHAR2(20),
    numero NUMBER,
    bairro VARCHAR2(20),
    cep VARCHAR2(8)
);


SELECT * FROM hospedagem;