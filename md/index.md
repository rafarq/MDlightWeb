Claro que sí, aquí tienes un texto con todos los elementos que se pueden formatear con Markdown, a modo de ejemplo:

# Este es un encabezado de nivel 1 (H1)

## Este es un encabezado de nivel 2 (H2)

### Este es un encabezado de nivel 3 (H3)

#### Este es un encabezado de nivel 4 (H4)

##### Este es un encabezado de nivel 5 (H5)

###### Este es un encabezado de nivel 6 (H6)

-----

Este es un párrafo de texto normal. Podemos escribir todo lo que queramos aquí. Podemos hacer **negritas** usando dos asteriscos o dos guiones bajos, así: `**negritas**` o `__negritas__`. También podemos hacer *cursivas* usando un asterisco o un guión bajo, así: `*cursiva*` o `_cursiva_`.

Incluso podemos combinar ambas y hacer ***negrita y cursiva*** usando tres asteriscos o tres guiones bajos, así: `***negrita y cursiva***` o `___negrita y cursiva___`.

Si queremos tachar texto, usamos dos virgulillas (el símbolo que va encima de la ñ), así: `~~tachado~~`. Se verá así: ~~tachado~~.

-----

Ahora vamos con las listas. Podemos hacer listas desordenadas usando asteriscos, guiones o símbolos de suma:

  * Elemento 1
  * Elemento 2
  * Elemento 3

<!-- end list -->

  - Elemento 1
  - Elemento 2
  - Elemento 3

<!-- end list -->

  - Elemento 1
  - Elemento 2
  - Elemento 3

O podemos hacer listas ordenadas usando números seguidos de un punto:

1.  Primer elemento
2.  Segundo elemento
3.  Tercer elemento

También podemos anidar listas dentro de otras:

1.  Primer elemento
      * Sub-elemento 1
      * Sub-elemento 2
2.  Segundo elemento
    1.  Sub-elemento A
    2.  Sub-elemento B
3.  Tercer elemento

-----

Para añadir un enlace, usamos corchetes para el texto del enlace y paréntesis para la URL:

Este es un enlace a [Google](https://www.google.com/url?sa=E&source=gmail&q=https://www.google.com).

-----

Para añadir una imagen, usamos un signo de exclamación, seguido de corchetes para el texto alternativo y paréntesis para la ruta de la imagen:

![Texto alternativo de la imagen](doc.png)

Esta imagen de arriba es un placeholder, puedes reemplazar la URL con la de cualquier imagen.

-----

También podemos hacer tablas:

| Encabezado 1 | Encabezado 2 | Encabezado 3 |
|--------------|--------------|--------------|
| Celda 1,1    | Celda 1,2    | Celda 1,3    |
| Celda 2,1    | Celda 2,2    | Celda 2,3    |
| Celda 3,1    | Celda 3,2    | Celda 3,3    |

-----

Y por último, podemos añadir bloques de código. Para un bloque de código en línea, usamos un acento grave, así: `código en línea`.

Para un bloque de código más largo, usamos tres acentos graves al principio y al final:

```
Este es un bloque de código.
Aquí podemos escribir varias líneas de código.
```

Podemos incluso especificar el lenguaje del código después de los primeros tres acentos graves para que se resalte la sintaxis:

```python
def saludar(nombre):
  print(f"Hola, {nombre}!")

saludar("Mundo")
```

-----

> Esto es una cita. Se crea utilizando el símbolo mayor que `>` al comienzo de la línea.

-----

Finalmente, un ejemplo de una línea horizontal, creada con tres o más guiones, asteriscos o guiones bajos:

-----

-----

-----

-----

Esto es un pie de página. Normalmente, se usa para notas al pie o referencias. Se crea usando `[^número]`:
Esta es una referencia a una nota al pie[^1].

-----

Y eso es todo, ¡un ejemplo completo de todos los elementos que se pueden formatear con Markdown\!

[^1]: Esta es la nota al pie.
