ALTER TABLE pessoa ADD CONSTRAINT PK_pessoa PRIMARY KEY (cpf);


ALTER TABLE telefonepessoa ADD CONSTRAINT PK_telefonepessoa PRIMARY KEY (cpfpessoa, telefone);
ALTER TABLE telefonepessoa ADD CONSTRAINT FK_telefonepessoa FOREIGN KEY (cpfpessoa) REFERENCES pessoa (cpf) ON DELETE CASCADE;


ALTER TABLE integrante ADD CONSTRAINT PK_integrante PRIMARY KEY (cpfpessoa);
ALTER TABLE integrante ADD CONSTRAINT FK_integrante FOREIGN KEY (cpfpessoa) REFERENCES pessoa (cpf) ON DELETE CASCADE;


ALTER TABLE espectador ADD CONSTRAINT PK_espectador PRIMARY KEY (cpfpessoa);
ALTER TABLE espectador ADD CONSTRAINT FK_espectador FOREIGN KEY (cpfpessoa) REFERENCES pessoa (cpf) ON DELETE CASCADE;


ALTER TABLE funcionario ADD CONSTRAINT PK_funcionario PRIMARY KEY (cpfpessoa);
ALTER TABLE funcionario ADD CONSTRAINT FK_funcionario FOREIGN KEY (cpfpessoa) REFERENCES pessoa (cpf) ON DELETE CASCADE;


ALTER TABLE turnofuncionario ADD CONSTRAINT PK_turnofuncionario PRIMARY KEY (cpffuncionario, horainicio, data);
ALTER TABLE turnofuncionario ADD CONSTRAINT FK_turnofuncionario FOREIGN KEY (cpffuncionario) REFERENCES funcionario (cpfpessoa) ON DELETE CASCADE;


ALTER TABLE webmaster ADD CONSTRAINT PK_webmaster PRIMARY KEY (cpffuncionario);
ALTER TABLE webmaster ADD CONSTRAINT FK_webmaster FOREIGN KEY (cpffuncionario) REFERENCES funcionario (cpfpessoa) ON DELETE CASCADE;


ALTER TABLE servico ADD CONSTRAINT PK_servico PRIMARY KEY (cnpj);


ALTER TABLE telefoneservico ADD CONSTRAINT PK_telefoneservico PRIMARY KEY (cnpjservico, telefone);
ALTER TABLE telefoneservico ADD CONSTRAINT FK_telefoneservico FOREIGN KEY (cnpjservico) REFERENCES servico (cnpj) ON DELETE CASCADE;


ALTER TABLE seguranca ADD CONSTRAINT PK_seguranca PRIMARY KEY (cnpjservico);
ALTER TABLE seguranca ADD CONSTRAINT FK_seguranca FOREIGN KEY (cnpjservico) REFERENCES servico(cnpj) ON DELETE CASCADE;


ALTER TABLE profissionalseg ADD CONSTRAINT PK_profissionalseg PRIMARY KEY (cpffuncionario);
ALTER TABLE profissionalseg ADD CONSTRAINT FK1_profissionalseg FOREIGN KEY (cpffuncionario) REFERENCES funcionario(cpfpessoa) ON DELETE CASCADE;
ALTER TABLE profissionalseg ADD CONSTRAINT FK2_profissionalseg FOREIGN KEY (cnpjseguranca) REFERENCES seguranca(cnpjservico) ON DELETE SET NULL;
    
    
ALTER TABLE ambulatorio ADD CONSTRAINT PK_ambulatorio PRIMARY KEY (cnpjservico);
ALTER TABLE ambulatorio ADD CONSTRAINT FK_ambulatorio FOREIGN KEY (cnpjservico) REFERENCES servico(cnpj) ON DELETE CASCADE;


ALTER TABLE medico ADD CONSTRAINT PK_medico PRIMARY KEY (cpffuncionario);
ALTER TABLE medico ADD CONSTRAINT FK1_medico FOREIGN KEY (cpffuncionario) REFERENCES funcionario(cpfpessoa) ON DELETE CASCADE;
ALTER TABLE medico ADD CONSTRAINT FK2_medico FOREIGN KEY (cnpjambulatorio) REFERENCES ambulatorio(cnpjservico) ON DELETE SET NULL;

ALTER TABLE atendimento ADD CONSTRAINT PK_atendimento PRIMARY KEY (cpfpessoa, cpfmedico, data);
ALTER TABLE atendimento ADD CONSTRAINT FK1_atendimento FOREIGN KEY (cpfpessoa) REFERENCES pessoa(cpf) ON DELETE CASCADE;
ALTER TABLE atendimento ADD CONSTRAINT FK2_atendimento FOREIGN KEY (cpfmedico) REFERENCES medico(cpffuncionario) ON DELETE CASCADE;


ALTER TABLE ocorrencia ADD CONSTRAINT PK_ocorrencia PRIMARY KEY (numero);
ALTER TABLE ocorrencia ADD CONSTRAINT FK_ocorrencia FOREIGN KEY (cpfprofissionalseg) REFERENCES profissionalseg(cpffuncionario) ON DELETE SET NULL;


ALTER TABLE ocorrenciapessoa ADD CONSTRAINT PK_ocorrenciapessoa PRIMARY KEY (cpfpessoa, numeroocorencia);
ALTER TABLE ocorrenciapessoa ADD CONSTRAINT FK1_ocorrenciapessoa FOREIGN KEY (cpfpessoa) REFERENCES pessoa(cpf) ON DELETE CASCADE;
ALTER TABLE ocorrenciapessoa ADD CONSTRAINT FK2_ocorrenciapessoa FOREIGN KEY (numeroocorencia) REFERENCES ocorrencia(numero) ON DELETE CASCADE;


ALTER TABLE lineup ADD CONSTRAINT PK_lineup PRIMARY KEY (data);


ALTER TABLE local ADD CONSTRAINT PK_local PRIMARY KEY (nome);


ALTER TABLE show ADD CONSTRAINT PK_show PRIMARY KEY (nomelocal, datalineup, horainicio);
ALTER TABLE show ADD CONSTRAINT FK1_show FOREIGN KEY (nomelocal) REFERENCES local(nome) ON DELETE CASCADE;
ALTER TABLE show ADD CONSTRAINT FK2_show FOREIGN KEY (datalineup) REFERENCES lineup(data) ON DELETE CASCADE;


ALTER TABLE banda ADD CONSTRAINT PK_banda PRIMARY KEY (nome);
ALTER TABLE banda ADD CONSTRAINT FK1_banda FOREIGN KEY (nomelocalshow, datalineupshow, horainicioshow) REFERENCES show(nomelocal, datalineup, horainicio) ON DELETE SET NULL;


ALTER TABLE integrantebanda ADD CONSTRAINT PK_integrantebanda PRIMARY KEY (nomebanda, cpfintegrante);
ALTER TABLE integrantebanda ADD CONSTRAINT FK1_integrantebanda FOREIGN KEY (nomebanda) REFERENCES banda(nome) ON DELETE CASCADE;
ALTER TABLE integrantebanda ADD CONSTRAINT FK2_integrantebanda FOREIGN KEY (cpfintegrante) REFERENCES integrante(cpfpessoa) ON DELETE CASCADE;


ALTER TABLE ingresso ADD CONSTRAINT PK_ingresso PRIMARY KEY (numero);
ALTER TABLE ingresso ADD CONSTRAINT FK1_ingresso FOREIGN KEY (cpfespectador) REFERENCES espectador(cpfpessoa) ON DELETE CASCADE;
ALTER TABLE ingresso ADD CONSTRAINT FK2_ingresso FOREIGN KEY (pertencedatalineup) REFERENCES lineup(data) ON DELETE CASCADE;


ALTER TABLE blog ADD CONSTRAINT PK_blog PRIMARY KEY (url);
ALTER TABLE blog ADD CONSTRAINT FK_blog FOREIGN KEY (datalineup) REFERENCES lineup(data) ON DELETE CASCADE;


ALTER TABLE post ADD CONSTRAINT PK_post PRIMARY KEY (id);
ALTER TABLE post ADD CONSTRAINT FK1_post FOREIGN KEY (urlblog) REFERENCES blog(url) ON DELETE CASCADE;
ALTER TABLE post ADD CONSTRAINT FK2_post FOREIGN KEY (cpfwebmaster) REFERENCES webmaster(cpffuncionario) ON DELETE SET NULL;


ALTER TABLE comentario ADD CONSTRAINT PK_comentario PRIMARY KEY (id);
ALTER TABLE comentario ADD CONSTRAINT FK1_comentario FOREIGN KEY (idpost) REFERENCES post(id) ON DELETE CASCADE;
ALTER TABLE comentario ADD CONSTRAINT FK2_comentario FOREIGN KEY (idresposta) REFERENCES comentario(id) ON DELETE CASCADE;


ALTER TABLE restaurante ADD CONSTRAINT PK_restaurante PRIMARY KEY(cnpj);


ALTER TABLE horariofunrest ADD CONSTRAINT PK_horariofunrest PRIMARY KEY(cnpjrestaurante);
ALTER TABLE horariofunrest ADD CONSTRAINT FK_horariofunrest FOREIGN KEY(cnpjrestaurante) REFERENCES restaurante(cnpj) ON DELETE CASCADE;


ALTER TABLE hospedagem ADD CONSTRAINT PK_hospedagem PRIMARY KEY(cnpj);