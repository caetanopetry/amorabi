@echo off
setlocal
cd /d "%~dp0"

set "NETWORK=amorabi-network"
set "MYSQL_CONTAINER=amorabi-mysql"
set "APACHE_CONTAINER=amorabi-apache"
set "MYSQL_ROOT_PASSWORD=amorabi_root_local"
set "MYSQL_DATABASE=amorabi_site"
set "MYSQL_USER=amorabi_app"
set "MYSQL_PASSWORD=amorabi_local_pass"

docker info >nul 2>&1
if errorlevel 1 (
    echo Docker nao esta disponivel. Inicie o Docker Desktop e tente novamente.
    exit /b 1
)

docker network inspect "%NETWORK%" >nul 2>&1
if errorlevel 1 docker network create "%NETWORK%"
if errorlevel 1 goto :error

docker rm -f "%APACHE_CONTAINER%" "%MYSQL_CONTAINER%" >nul 2>&1

echo Criando imagem Apache/PHP...
docker build -f dockerfile.apache -t amorabi-apache:local .
if errorlevel 1 goto :error

echo Criando imagem MySQL...
docker build -f Dockerfile.mysql -t amorabi-mysql:local .
if errorlevel 1 goto :error

echo Iniciando MySQL...
docker run -d --name "%MYSQL_CONTAINER%" --network "%NETWORK%" --restart unless-stopped -p 3306:3306 -e MYSQL_ROOT_PASSWORD=%MYSQL_ROOT_PASSWORD% -e MYSQL_DATABASE=%MYSQL_DATABASE% -e MYSQL_USER=%MYSQL_USER% -e MYSQL_PASSWORD=%MYSQL_PASSWORD% -v amorabi-mysql-data:/var/lib/mysql amorabi-mysql:local
if errorlevel 1 goto :error

echo Aguardando o banco de dados...
for /l %%i in (1,1,30) do (
    docker exec "%MYSQL_CONTAINER%" mysqladmin ping -h 127.0.0.1 -uroot -p%MYSQL_ROOT_PASSWORD% --silent >nul 2>&1
    if not errorlevel 1 goto :database_ready
    timeout /t 2 /nobreak >nul
)
echo MySQL nao ficou pronto dentro do tempo esperado.
goto :error

:database_ready
echo Iniciando Apache/PHP...
docker run -d --name "%APACHE_CONTAINER%" --network "%NETWORK%" --restart unless-stopped -p 8080:80 -e APP_ENV=local -e APP_URL=http://localhost:8080 -e DB_HOST=%MYSQL_CONTAINER% -e DB_PORT=3306 -e DB_NAME=%MYSQL_DATABASE% -e DB_USER=%MYSQL_USER% -e DB_PASS=%MYSQL_PASSWORD% amorabi-apache:local
if errorlevel 1 goto :error

echo Aplicacao: http://localhost:8080
echo MySQL: localhost:3306
echo Credenciais locais de desenvolvimento: usuario %MYSQL_USER%, senha %MYSQL_PASSWORD%
echo Os arquivos SQL sao executados apenas na primeira inicializacao do volume amorabi-mysql-data.
exit /b 0

:error
echo Ocorreu um erro ao criar ou iniciar os containers.
exit /b 1