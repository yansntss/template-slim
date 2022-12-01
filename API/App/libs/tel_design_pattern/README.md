# Tel Design Pattern

## :page_with_curl: Classes

## 🔥 Classe Login

Nesta classe, estão contidos os métodos de manipulação de login do usuário nas ferramentas tel e busca básica de dados do usuário no sisfreq.
Ao instaciar a classe, você deve passar o site, login e senha. Todos esses atributos são do tipo string.

### 📄 Métodos

#### ⭐ 1) logarAd
    Parâmetros: sem parâmetros

    Retorno: array

    Dados de retorno: 
     - Posição 0: resultado (int)
       O resultado é classificado em três tipos: 
         1) -1: Falha ao conectar com o AD
         2) 0: Credenciais inválidas
         3) 1: Credenciais válidas
     - Posição 1: login (string)
 
 #### ⭐ 2) listaConexoesSisfreq
    Parâmetros: sem parâmetros

    Retorno: array

    Dados de retorno: 
     - Posição 0: servidor
     - Posição 1: banco
     - Posição 2: usuario
     - Posição 3: senha
     
 #### ⭐ 3) buscaUsuarioSisfreq
    Parâmetros: conexão (array) => conexão com o banco de dados (servidor, banco, usuario, senha)

    Retorno: array

    Dados de retorno: Array com os dados do usuário pesquisado
     - NOME
     - AUTO_APELIDO_GESTORES
     - FUNCAO
     - SUPERVISOR
     - COORDENADOR 
     - MATRICULA
     - SERVICO
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error
     
## 🔥 Classe Sisfreq
Nesta classe, estão contidos os métodos de busca e manipulação de dados do sisfreq. <br>
Ao instaciar a classe, você deve passar o site por parâmetro.

### 📄 Métodos
#### ⭐ 1) buscaTodosUsuarios
    Parâmetros: sem parâmetros

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - MATRICULA
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 
    
#### ⭐ 2) buscaUsuario
    Parâmetros: login (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - MATRICULA
    - SERVICO
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 

#### ⭐ 2) buscaUsuarioComLoginSite
    Parâmetros: login (string) | site (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - MATRICULA
    - SERVICO
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 

    
#### ⭐ 3) buscarUsuarioPorNome
    Parâmetros: nome (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - SERVICO
    - EMAIL
    - LOGIN_REDE
    - LOGIN_PLATAFORMA
    - MATRICULA
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 
    
#### ⭐ 4) buscarUsuarioPorServico
    Parâmetros: servico (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - SERVICO
    - EMAIL
    - LOGIN_REDE
    - LOGIN_PLATAFORMA
    - MATRICULA
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 


#### ⭐ 5) buscarEquipeGestor
    Parâmetros: login (string) | cargo (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - SERVICO
    - EMAIL
    - LOGIN_REDE
    - LOGIN_PLATAFORMA
    - MATRICULA
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 

#### ⭐ 6) query
    Parâmetros: query (string)

    Retorno: array

    Dados de retorno: os solicitados pela consulta    
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 

#### ⭐ 7) buscaUsuarioMatricula
    Parâmetros: matricula (string)

    Retorno: array

    Dados de retorno:
    - NOME
    - AUTO_APELIDO_GESTORES
    - FUNCAO
    - SUPERVISOR
    - COORDENADOR
    - MATRICULA
    - SERVICO
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 

## 🔥 Classe Excel  
Nesta classe estão contidos métodos para a manipulação básica de arquivos Excel. <br>
Ao instanciar a classe, você deve passar a conexã com o banco de dados vigente (tipo: mysqli)

### 📄 Métodos
#### ⭐ 1) download
    Parâmetros: heads (array), bodyContent (array), consulta (string), utf8 (string), uppercase (bool).

    Retorno: Excel (retorno a própria classe, dando a possibilidade de trabalhar com métodos encadeados).

    Dados de retorno: Classe Excel  
    
#### ⭐ 2) upload
    Parâmetros: nomeInput (string), nomeTabela (string), camposInsert (string), tipoArquivo (string).
    
    Retorno: array
        - posição 0 => resposta: contém a quantidade de inserts feitos no banco de dados
    
    OBS: 
        - Caso você informe um tipo de arquivo não implementado, o método retornará um array com uma posição chamada resposta
        - Caso a query dê erro, o método devolve um array com uma posição chamada resposta 
        
## 🔥 Classe SqlServer
Nesta classe, são contidos métodos para a manipulação em bancos de dados SQL Server. <br>

Ao instanciar esta classe, você deve informar: <br>
    1) servidor <br>
    2) banco <br>
    3) usuario <br>
    4) senha <br>
    
### 📄 Métodos
#### ⭐ 1) query
    Parâmetros: query (string)

    Retorno: array

    Dados de retorno: os solicitados pela consulta    
    
    OBS: Caso a query dê erro, o método devolve um array com uma posição chamada error 
    
## 🔥 Classe Utilities

Nesta classe, estão contidos os métodos de limpeza de campos de formulário e outros utilidades. <br>

**OBS: Está classe é abstrata, logo não precisa de instância**

### 📄 Métodos
#### ⭐ 1) limpaRequestBody
    Parâmetros: dados (array), tipoConexao (string), conexao (object)

    Retorno: array

    Dados de retorno: Array associativo com os dados limpos e tratados
    
#### ⭐ 2) limpaCampo
    Parâmetros: campo (string), tipoConexao (string), conexao (object)

    Retorno: string

    Dados de retorno: Campo limpo e previnido contra SQL INJECTION e CROSS SITE SCRIPT
    
#### ⭐ 3) trataCampo
    Parâmetros: campo (string)

    Retorno: string

    Dados de retorno: String tratada e com espaços em branco retirados
    
#### ⭐ 4) verificaQtdCamposRequest
    Parâmetros: camposNecessarios (array), camposInformados (array)

    Retorno: bool

    Dados de retorno: Retorna um booleano informado se todos os campos foram informados ou não
    
    
## 🔥 Classe Email
Nesta classe, estão contidos os métodos para envio de email <br>

Ao instanciar esta classe, você deve informar: <br>
    1) Email <br>
    2) Senha <br>
    
### 📄 Métodos
#### ⭐ 1) send
    Parâmetros: 
        emailRemetente (string), nomeRemetente (string), emailDestinatario (string), nomeDestinatario (string), assunto (string), corpoEmail (string)

    Retorno: array

    Dados de retorno: Mensagem de retorno se o envio foi realizado
