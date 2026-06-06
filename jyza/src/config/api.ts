// Configuración de API
// El servidor CakePHP sirve desde webroot como raíz
// Entonces la ruta es: /api/content/section/{seccion}/index.php

let API_URL = 'http://localhost:8000';

// En el navegador, siempre usar localhost:8000
if (typeof window !== 'undefined') {
  API_URL = 'http://localhost:8000';
} else {
  // En SSR (server-side rendering), usar jyza-admin (nombre del container)
  API_URL = 'http://jyza-admin:8000';
}

export { API_URL };

export const API_ENDPOINTS = {
  bienvenida: `${API_URL}/api/content/section/bienvenida/index.php`,
  porqueelegirnos: `${API_URL}/api/content/section/porqueelegirnos/index.php`,
  especialistas: `${API_URL}/api/content/section/especialistas/index.php`,
  especialidades: `${API_URL}/api/content/section/especialidades/index.php`,
  clubjyza: `${API_URL}/api/content/section/clubjyza/index.php`,
  paquetes: `${API_URL}/api/content/section/paquetes/index.php`,
  testimonios: `${API_URL}/api/content/section/testimonios/index.php`,
  citas: `${API_URL}/api/content/section/citas/index.php`,
  agendamiento: `${API_URL}/api/content/section/agendamiento/index.php`,
  comollegar: `${API_URL}/api/content/section/comollegar/index.php`,
  indicadores: `${API_URL}/api/content/section/indicadores/index.php`,
};
