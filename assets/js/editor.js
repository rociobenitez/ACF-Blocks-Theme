// Importa el archivo CSS del editor
import '../css/editor.css';

// Importa automáticamente todos los editor.css de los bloques
const blockStyles = import.meta.globEager('../blocks/**/editor.css');