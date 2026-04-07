# Easy-to-Read Advisor

Aplicacion web PHP para evaluar si diapositivas en formato HTML cumplen pautas de Lectura Facil.

## Objetivo

Easy-to-Read Advisor analiza una diapositiva HTML y genera una valoracion de accesibilidad basada en:

- Pautas de texto (12 reglas)
- Pautas de maquetacion (10 reglas)

El resultado incluye:

- Clasificacion global (`Bajo`, `Regular`, `Alto`)
- Puntuacion por porcentaje
- Detalle de pautas correctas e incorrectas
- Grafico visual de aciertos/fallos

## Arquitectura del proyecto

Proyecto sin framework (PHP procedural + vistas PHP).

- `index.php`: pagina principal, subida de archivo, informacion y formulario de contacto.
- `input/upload.php`: validacion/subida del HTML y redireccion a resultados.
- `result.php`: orquestacion de analisis y render de resultados.
- `analyzer/textAnalyzer.php`: reglas de analisis textual.
- `analyzer/designAnalyzer.php`: reglas de analisis de maquetacion.
- `analyzer/textConverter.php`: extraccion de texto desde el HTML.
- `analyzer/morphosyntacticAnalyzer.php`: integracion con MeaningCloud para analisis morfosintactico.
- `contact.php`: envio de correo con PHPMailer por SMTP.
- `parameters.txt`: catalogo central de pautas, pesos, umbrales y mensajes.
- `css/`, `scripts/`, `images/`: capa visual y comportamiento en cliente.

## Flujo funcional

1. Usuario carga un archivo `.html` desde `index.php` y elige el tipo de analisis:
   - `todas`
   - `texto`
   - `maquetacion`
2. `input/upload.php` valida el archivo (MIME/extension), lo mueve a `input/tmp/`, anade meta UTF-8 y guarda referencia en sesion.
3. Redireccion a `result.php` con la opcion elegida.
4. `result.php` ejecuta `textAnalyzer()` y/o `designAnalyzer()`.
5. Se calcula puntuacion final en base a pesos definidos en `parameters.txt`.
6. Se renderiza clasificacion, detalle de errores y grafico.

## Reglas evaluadas

### Texto (12 pautas)

Incluye, entre otras:

- Longitud de frases
- Numeros grandes
- Caracteres especiales y de orden
- Longitud de oraciones por palabras
- Formato de fechas
- Uso de pronombres
- Numeros romanos
- Persona gramatical
- Voz pasiva
- Presencia de sujeto
- Estructura sujeto + verbo + complementos

### Maquetacion (10 pautas)

- Fuente permitida
- Tamano de fuente en rango
- No cursiva
- Limite de negritas/subrayados
- Sin sombras
- Control de mayusculas
- Texto en negro
- Fondo en blanco
- Limite de palabras por diapositiva

## Requisitos

- PHP compatible con `^7.2.11` (segun `composer.json`)
- Extension `mbstring`
- Dependencias Composer (PHPMailer)
- Acceso saliente a Internet para:
  - API de MeaningCloud (analisis morfosintactico)
  - CDNs (Bootstrap/jQuery/Chart.js)
  - SMTP (si se usa formulario de contacto)

## Instalacion

1. Clonar el repositorio.
2. Instalar dependencias:

```bash
composer install
```

3. Servir el proyecto con PHP embebido o servidor web.

Ejemplo con servidor embebido:

```bash
php -S localhost:8000
```

4. Abrir en navegador:

`http://localhost:8000/index.php`

## Configuracion

### Parametros de reglas y scoring

El archivo `parameters.txt` define:

- Textos de pautas
- Pesos por pauta
- Umbrales de validacion (fuentes, tamanos, maximos, etc.)
- Mensajes de clasificacion/comentario

Importante: actualmente se accede por indices de linea (`file(...)[N]`), por lo que modificar el orden del archivo puede romper la logica.

### Correo de contacto

`contact.php` usa PHPMailer con SMTP. Revisar y adaptar:

- Host
- Puerto
- Usuario
- Contrasena

### API de analisis morfosintactico

`analyzer/morphosyntacticAnalyzer.php` usa MeaningCloud. Es necesario configurar una clave valida para el entorno de despliegue.

## Estructura de salida de analizadores

Los analizadores devuelven arrays asociativos por codigo de pauta (`P1`, `P2`, ...):

- Si una pauta aparece en el array: hay error.
- Si no aparece: se considera correcta.

`result.php` suma el peso de cada pauta correcta para calcular la puntuacion.

## Limitaciones conocidas

- Dependencia fuerte de `parameters.txt` por posicion de lineas.
- Heuristicas linguisticas sensibles al formato de salida de la API externa.
- Latencia en analisis textual por llamadas remotas y `sleep(1)` por oracion.
- El formulario de contacto y la API usan configuracion sensible que debe externalizarse por seguridad en produccion.

## Recomendaciones para evolucion

- Mover credenciales y claves a variables de entorno.
- Sustituir acceso por indice en `parameters.txt` por formato con claves (JSON/YAML/INI).
- Anadir validaciones robustas de respuestas de API.
- Incorporar pruebas automatizadas de reglas.
- Implementar logging y manejo de errores centralizado.

## Creditos

Aplicacion desarrollada en el contexto del proyecto SlideWiki (Horizon 2020).
