import interFont from '../fonts/inter/Inter-VariableFont_wght.woff2?url';


// Importar CSS globales del tema
import '@css/fonts.css';
import '@css/main.css';

// Importa automáticamente todos los styles.css de los bloques
const blockStyles = import.meta.glob('../../blocks/**/style.css', { eager: true });

// console.log(blockStyles);
console.log('Inter font loaded from:', interFont);

// Aquí puedes agregar cualquier JavaScript específico del editor que necesites
console.log('Editor script loaded');