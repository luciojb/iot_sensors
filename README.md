# iot_sensors

O repositório contém todo o conteúdo do projeto de visão do sistema IoT. 

Uso dos frameworks: Laravel, Bootstrap e Doctrine

--Dependências:

1. PHP 7.1+ (pc & raspberry)

2. MySQL (pc & raspberry)

3. Testado no Linux

4. Composer (pc & raspberry)

5. PHP PEAR (raspberry)

5.1. pear mail2 (raspberry)

6. mosquitto-PHP (pc & raspberry), encontrado aqui: [ubuntu](https://www.vultr.com/docs/how-to-install-mosquitto-mqtt-broker-server-on-ubuntu-16-04) e [raspberry](https://stackoverflow.com/questions/37391010/mosquitto-php-library-in-raspberry-and-windows)

7. Bibliotecas Arduino:

7.1. Adafruit_Unified_Sensor

7.2. DHT_sensor_library

7.3. UIPEthernet

##

--Procedimento para instalação e configuração

Esse procedimento só será possível após todas as dependências estarem instaladas.

Se ocorrer algum erro com banco de dados ou algo nesse sentido, rode os scripts do banco (item *4*)

1. Clone o repositório

2. Edite o arquivo **.env** com as credenciais do banco de dados

2.2. Foi utilizado o MySQL como servidor de banco de dados.

3. vá para a pasta ***iot_sensors/sensor_iot/***. Os próximos itens são uma lista de comandos.

3.1. *composer install && composer update*

3.2. *php artisan key:generate*

3.3. *php artisan package:discover*

3.4. *php artisan vendor:publish*

4. Gerar o banco de dados:

4.1. No raspberry, o arquivo do script está em: 

-iot_sensors/sensor_iot/resources/project_resources/database_scripts/raspberry_database_schemma.sql

4.2. O arquivo do script da aplicação está em:

-iot_sensors/sensor_iot/resources/project_resources/database_scripts/sensor_application_sql.sql

5. *doctrine:generate:proxies*

6. *php artisan route:list*

6. *php artisan serve* ~ executa a aplicação do laravel. deixar exxecutando

##

Estrutura básica: 

1. A pasta **iot_sensors/sensor_iot/resources/project_resources/raspberry_and_server/dht22** possui o código do Arduino

2. A pasta **iot_sensors/sensor_iot/resources/project_resources/raspberry_and_server/gtw** possui os códigos dos sockets da aplicação e do raspberry, além dos códigos para o MQTT.

2.1. *circularSensorList.php, database.php, mail.php, main.php, mosquittoPub.php, sensor.php* so os arquivos usados no raspberry. só é necessária a execução do **main.php**. Todos os arquivos citados devem estar na mesma pasta

2.1.1. *php main.php*

2.2. No pc, onde a aplicação está rodando, os arquivos que devem estar na mesma pasta são: *mosquittoSub.php e applicationDatabase.php*, executar:

2.2.1. *mosquitto -p 15200* ~ inicializa o mosquitto-php. A porta de conexo é 15200.

2.2.2. Em outra aba do terminal, executar:

2.2.2.1. **php mosquittoSub.php**

Isso fará com que o mosquitto subscreva a um tópico e ouça as conexões vindas.

3. Executar o código do arduino

Isso forma o sistema todo


##

#Os trabalhos futuros são bem vidos a partir das issues. 

#Por favor, contribua com funcionalidades que gostaria de ver no projeto
