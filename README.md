
# Template Front-End con caracteristicas de seguridad de la informacion

## Lista de características disponibles

1. Guía de estilo de código fuente

    El diseño del template tiene en cuenta la adhesión a la guía de estilo de AirBnB, disponible en https://github.com/airbnb/javascript. Este enfoque busca mantener coherencia y buenas prácticas en el código fuente, siguiendo las recomendaciones establecidas por AirBnB para el desarrollo en JavaScript.

    Cubre el control de seguridad:
    * [Secure system architecture and engineering   principles](https://www.iso.org/standard/27001) 
      Reforzando la importancia de aplicar principios específicos de seguridad en la codificación del software.

2. Validación de datos de entrada
    
    Se considera la validación de los tipos de datos ingresados
    - Guía de uso e implementación
            
    En la ruta src/boot/directive.js se encuentran directivas. En inputs agregar la directiva que corresponda al tipo de dato que se pretende restringir.

    Cubre el control de seguridad:

    - [Application security requirements](https://www. iso.org/standard/27001) 

    - [A01:2021 - Broken Access Control](https://owasp.org/Top10/A01_2021-Broken_Access_Control/)

    Evidencia de prueba satisfactoria
    
    Por ejemplo: La directiva personalizada 'my-only-alphanumeric' en el código proporcionado tiene como objetivo restringir el contenido de un campo de entrada (input) en el front end a caracteres alfanuméricos, permitiendo solo letras (tanto minúsculas como mayúsculas) y números. 

3. Sistema de autenticación de un factor (usuario y contraseña)

    Se cuenta con un sistema de autenticación basado en un único factor, que requiere la combinación de un nombre de usuario y una contraseña para verificar la identidad del usuario.

    Cubre el control de seguridad:
    - [Privileged access rights](https://www.iso.org/standard/27001) 
    - [Information access restriction](https://www.iso.org/standard/27001)
    - [secure authentication](https://www.iso.org/standard/27001)
    Dejando únicamente que una vez se haya autenticado podrá acceder al sistema.
    - [Use of criptography](https://www.iso.org/standard/27001)
    - [A02:2021-Criptographic failures](https://owasp.org/Top10/A02_2021-Cryptographic_Failures/):
    
    Se emplea criptografía mediante el hashing de contraseñas con salida única para garantizar la seguridad en el almacenamiento y verificación de las credenciales de los usuarios.

4. Uso de software actualizado
    
    En la implementación del template, se ha optado por utilizar la versión más reciente del framework [Quasar (v2.14.0)](https://quasar.dev/) para el desarrollo del lado del cliente, junto con [Laravel 10](https://laravel.com/docs/10.x) en el lado del servidor, buscando aprovechar las últimas funcionalidades y mejoras proporcionadas por ambas tecnologías.

    Cubriendo el control de seguridad:
    * [A06:2021 - Vulnerable and Outdated Components]( https://owasp.org/Top10/A06_2021-Vulnerable_and_Outdated_Components/ )


5. Borrado lógico (soft delete)
   
    El borrado lógico permite marcar registros como "eliminados" sin eliminar físicamente la información. Esto es beneficioso para preservar la integridad de los datos y, al mismo tiempo, cumplir con requisitos de privacidad o regulaciones que puedan exigir la eliminación de cierta información. Esto quiere decir que si borramos la base de datos, tenemos un registro aparte que nos permitirá restaurarla.

    Satisface el control de seguridad:
- [Information deletion](https://www.iso.org/standard/27001)
- [Information backup](https://www.iso.org/standard/27001)
    
    Esto permite mantener un historial de cambios en la base de datos, lo que puede ser útil en situaciones en las que es importante conservar versiones anteriores de los datos. 

6. Mecanismos contra ingreso de datos XSS o inyección SQL
    
    El sistema no permite la entrada de datos con palabra clave como lo son "script" "alert" etc. de tal forma que evitamos cualquier ataque de inyección SQL
    
    Satisface el control de seguridad
    - [Protection against malware](https://www.iso.org/standard/27001)
    - [A03:2021 - Injection](https://owasp.org/Top10/A03_2021-Injection/)

7. Monitoreo de inicio de sesión

    Cubre el control de seguridad 
    - [Capacity management](https://www.iso.org/standard/27001)

    - [A09:2021 – Security Logging and Monitoring Failures](https://owasp.org/Top10/A09_2021-Security_Logging_and_Monitoring_Failures/)

8. Mecanismo para evitar generación de patrones.
    
    Se implementa funciones de cifrado con hash en las direcciones de la aplicacion para evitar que se detecte un patrón

    Cubriendo los controles de seguridad:
    - [Data Leakage Prevention](https://www.iso.org/standard/27001) 
    - [A05:2021 Security Misconfiguration](https://owasp.org/Top10/es/A03_2021-Injection/)
    - [Secure Coding](https://www.iso.org/standard/27001)

9. Diseño de base de datos seguro.
    
    Corroborando que los datos de entrada coincidan con lo permitido, es decir, si tenemos un campo input o donde se pida ingresar únicamente cinco números, verificar que no se introduzcan letras, caracteres y/o símbolos.
    Al igual que en campo de entrada de texto evitar palabras tales como "script" o alguna otra que nos vulnere el sistema.

    Cubriendo puntos de seguridad:
    - [Data Masking](https://www.iso.org/standard/27001)
    - [Injection](https://owasp.org/Top10/es/A03_2021-Injection/)

10. Establecer un número máximo de sesiones abiertas en cualquier navegador.

    Se establece un número máximo de sesiones, es decir, en un navegador únicamente podremos accesar una sola vez, denegando que en el mismo navegador podamos abrir otra sesión, esta se abrirá únicamente despues de que se cierre la sesión en la pestaña donde se tenía abierta.
    Al mismo tiempo también se ha implementado un temporizador que una vez entrando a la sesión y despúes de un límite de tiempo no teniendo actividad, se cierre la sesión.

11. Peticiónes limitadas
    Se implementa un número máximo de peticiones, esto quiere decir que el usuario podrá hacer una determinada cantidad de peticiones de tal manera que cuando exceda ese número el sistema ya no le permita hacer más y recibirá un mensaje de error.

