# Uso de IA en este proyecto

## 1. Herramientas utilizadas

| Herramienta | Versión / Modelo | Modo de uso | Aprox. % del trabajo |
|-------------|------------------|-------------|----------------------|
| DeepSeek | Última versión | Chat interactivo en web | 50% |
| GitHub Copilot | Última versión | Autocompletado en VS Code | 20% |
| Ninguna | | yo mismo | 30% |

## 2. Configuración del proyecto

### CLAUDE.md / AGENTS.md
No tengo archivo de instrucciones a nivel proyecto. No lo consideré necesario para este módulo.

### settings.json u otra configuración equivalente
No realicé cambios especiales en la configuración. Usé la configuración por defecto de las herramientas.

## 3. Skills personalizadas
Ninguna.

## 4. Slash commands personalizados
Ninguno.

## 5. Sub-agentes invocados
Ninguno.

## 6. MCPs (Model Context Protocol)

| MCP | Para qué lo usaste | ¿Qué te aportó? |
|-----|-------------------|-----------------|
| Ninguno | - | - |

No utilicé MCPs porque el desarrollo fue local y directo. Con más tiempo, habría usado algo para acceder a la documentación de Prestashop y evitar alucinaciones con los hooks.

## 7. Prompts importantes

### Prompt 1
- **Herramienta:** DeepSeek
- **Prompt:** "No me crea las tablas en la base de datos, el módulo se instala pero no hay tablas"
- **Qué generó (resumen):** Código de debug para verificar rutas, método alternativo para crear tablas
- **Qué hice con el output:** Usé el código de debug para identificar que el archivo sql/install.php no se estaba incluyendo correctamente

### Prompt 2
- **Herramienta:** DeepSeek
- **Prompt:** "Las badges no se ven en el frontend, solo en ficha de producto"
- **Qué generó (resumen):** Solución usando hookDisplayProductPriceBlock como alternativa
- **Qué hice con el output:** Implementé la solución y funcionó en categorías y búsqueda

### Prompt 3
- **Herramienta:** DeepSeek
- **Prompt:** "Necesito la pantalla de configuración del módulo con HelperForm"
- **Qué generó (resumen):** Método getContent() completo con formulario de configuración y preview
- **Qué hice con el output:** Acepté y adapté a mis necesidades

## 8. Errores de la IA que detecté

### Error 1: Hook incorrecto para listados
- **Qué generó la IA (mal):** Sugirió usar `displayProductListReviews` como hook universal
- **Por qué estaba mal:** En algunos temas de PrestaShop 1.7 este hook no se ejecuta en categorías
- **Cómo lo corregiste:** Implementé también `displayProductPriceBlock` que es más universal

### Error 2: Error de 'id_configuration'
- **Qué generó la IA (mal):** El AdminController intentaba ordenar por 'id_configuration'
- **Por qué estaba mal:** Heredaba configuración de otro controlador que usaba ese campo
- **Cómo lo corregiste:** Añadí `$this->_defaultOrderBy = 'id_productbadge'` en el constructor

### Error 3: Selector de badges sin diseño visual
- **Qué generó la IA (mal):** El template product_badges_selector.tpl solo mostraba el estado activo
- **Por qué estaba mal:** No mostraba el texto ni los colores de la badge
- **Cómo lo corregiste:** Reescribí el template para mostrar un span con el estilo de cada badge

## 9. Partes que NO usé IA

- **Resolución de conflictos de git**: Lo hice manualmente porque necesitaba entender qué cambios conservar
- **Configuración del entorno XAMPP**: Problemas de MySQL y Apache los resolví yo mismo
- **Instalación de idioma inglés en PrestaShop**: Proceso manual desde el back office
- **Pruebas de frontend**: Verificación manual de que las badges se ven correctamente

## 10. Reflexión final

### ¿Qué te ahorró la IA?
- El tiempo de escribir la estructura base del módulo (hooks, ObjectModel, AdminController)
- La sintaxis correcta de HelperForm y HelperList
- Las consultas SQL con los prefijos correctos de PrestaShop
- Debugging

### ¿En qué te entorpeció o te llevó por mal camino?
- Me hizo perder tiempo con el hook `displayProductListReviews` cuando no funcionaba
- Los errores con las rutas de archivos me llevaron a depurar manualmente

### ¿Qué cambiarías de tu flujo con IA si lo repitieras?
- Leería la documentación oficial de PrestaShop en paralelo para validar lo que genera la IA
- Haría commits más pequeños y frecuentes para poder revertir errores fácilmente
- Configuraría un entorno de desarrollo más estable (posiblemente Docker) para evitar problemas de XAMPP