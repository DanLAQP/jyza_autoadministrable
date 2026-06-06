// Server-side (SSR Node.js en container): red interna Docker, sin salir al exterior
// Browser (usuario): URL pública con CORS habilitado
const API_URL = typeof window !== 'undefined'
  ? 'https://admin.ginecologiajyza.pe'
  : 'http://jyza-admin:8000';

export { API_URL };

export const API_ENDPOINTS = {
  bienvenida:       `${API_URL}/api/content/section/bienvenida/index.php`,
  porqueelegirnos:  `${API_URL}/api/content/section/porqueelegirnos/index.php`,
  especialistas:    `${API_URL}/api/content/section/especialistas/index.php`,
  especialidades:   `${API_URL}/api/content/section/especialidades/index.php`,
  clubjyza:         `${API_URL}/api/content/section/clubjyza/index.php`,
  paquetes:         `${API_URL}/api/content/section/paquetes/index.php`,
  testimonios:      `${API_URL}/api/content/section/testimonios/index.php`,
  citas:            `${API_URL}/api/content/section/citas/index.php`,
  agendamiento:     `${API_URL}/api/content/section/agendamiento/index.php`,
  comollegar:       `${API_URL}/api/content/section/comollegar/index.php`,
  indicadores:      `${API_URL}/api/content/section/indicadores/index.php`,
};
