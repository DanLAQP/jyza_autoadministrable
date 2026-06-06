/**
 * src/hooks/useContent.ts
 * 
 * Hook para obtener contenido desde la API CakePHP
 * Uso en páginas y componentes Astro
 */

export interface ContentBlock {
  id?: number;
  type: 'text' | 'textarea' | 'wysiwyg' | 'image' | 'video' | 'json';
  content: string;
  metadata?: Record<string, any>;
}

export interface ContentImage {
  id: number;
  url: string;
  alt: string;
  title?: string;
  dimensions?: {
    width: number;
    height: number;
    versions?: Record<string, any>;
  };
}

export interface SectionContent {
  id: number;
  slug: string;
  title: string;
  description?: string;
  metadata: Record<string, any>;
  blocks: Record<string, ContentBlock>;
  images: ContentImage[];
  updated_at: string;
}

/**
 * Obtener contenido de una sección específica
 * 
 * @param slug - Slug de la sección (ej: 'bienvenida', 'nosotros')
 * @param baseUrl - URL base de la API (por defecto usa PUBLIC_API_URL)
 * @returns Contenido de la sección o null
 * 
 * @example
 * const content = await getSectionContent('bienvenida');
 * console.log(content.blocks.titulo.content);
 */
export async function getSectionContent(
  slug: string,
  baseUrl: string = import.meta.env.PUBLIC_API_URL
): Promise<SectionContent | null> {
  if (!baseUrl) {
    console.error(
      'PUBLIC_API_URL no está definida en .env.local. Configuralo con: PUBLIC_API_URL=http://localhost:3000'
    );
    return null;
  }

  try {
    const response = await fetch(`${baseUrl}/api/v1/content/${slug}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Cache-Control': 'public, max-age=3600',
      },
    });

    if (!response.ok) {
      console.error(
        `Error cargando contenido de sección '${slug}': ${response.status} ${response.statusText}`
      );
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error(`Error obteniendo contenido '${slug}':`, error);
    return null;
  }
}

/**
 * Obtener todo el contenido (para pregenerar en build de Astro)
 * 
 * @param baseUrl - URL base de la API (por defecto usa PUBLIC_API_URL)
 * @returns Objeto con todas las secciones
 * 
 * @example
 * const allContent = await getAllContent();
 * console.log(Object.keys(allContent)); // ['bienvenida', 'nosotros', 'servicios', ...]
 */
export async function getAllContent(
  baseUrl: string = import.meta.env.PUBLIC_API_URL
): Promise<Record<string, SectionContent> | null> {
  if (!baseUrl) {
    console.error('PUBLIC_API_URL no está definida');
    return null;
  }

  try {
    const response = await fetch(`${baseUrl}/api/v1/content`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      console.error(`Error cargando contenido: ${response.status}`);
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error('Error obteniendo contenido:', error);
    return null;
  }
}

/**
 * Extraer contenido específico de un bloque
 * 
 * @param content - Contenido de la sección
 * @param blockKey - Clave del bloque
 * @param fallback - Valor por defecto si el bloque no existe
 * @returns Contenido del bloque
 * 
 * @example
 * const titulo = getBlockContent(content, 'titulo', 'Título por defecto');
 */
export function getBlockContent(
  content: SectionContent | null,
  blockKey: string,
  fallback: string = ''
): string {
  if (!content?.blocks?.[blockKey]) {
    return fallback;
  }

  return content.blocks[blockKey].content || fallback;
}

/**
 * Obtener contenido de múltiples bloques
 * 
 * @param content - Contenido de la sección
 * @param blockKeys - Array de claves de bloques
 * @returns Objeto con los contenidos
 * 
 * @example
 * const blocks = getMultipleBlocks(content, ['titulo', 'descripcion', 'cta_text']);
 * console.log(blocks.titulo, blocks.descripcion, blocks.cta_text);
 */
export function getMultipleBlocks(
  content: SectionContent | null,
  blockKeys: string[]
): Record<string, string> {
  const result: Record<string, string> = {};

  blockKeys.forEach(key => {
    result[key] = getBlockContent(content, key);
  });

  return result;
}

/**
 * Obtener primera imagen de la sección
 * 
 * @param content - Contenido de la sección
 * @param index - Índice de la imagen (por defecto 0)
 * @returns Imagen o null
 * 
 * @example
 * const heroImage = getImage(content, 0);
 */
export function getImage(
  content: SectionContent | null,
  index: number = 0
): ContentImage | null {
  return content?.images?.[index] || null;
}

/**
 * Obtener todas las imágenes
 * 
 * @param content - Contenido de la sección
 * @returns Array de imágenes
 */
export function getImages(content: SectionContent | null): ContentImage[] {
  return content?.images || [];
}

/**
 * Obtener URL de imagen en tamaño específico
 * 
 * @param content - Contenido de la sección
 * @param imageIndex - Índice de la imagen
 * @param size - Tamaño ('original', 'thumbnail', 'medium', 'large')
 * @returns URL de la imagen o null
 * 
 * @example
 * const thumbnailUrl = getImageUrl(content, 0, 'thumbnail');
 */
export function getImageUrl(
  content: SectionContent | null,
  imageIndex: number = 0,
  size: 'original' | 'thumbnail' | 'medium' | 'large' = 'original'
): string | null {
  const image = content?.images?.[imageIndex];

  if (!image) {
    return null;
  }

  if (size === 'original') {
    return image.url;
  }

  return image.dimensions?.versions?.[size]?.path || image.url;
}

/**
 * Obtener metadatos de SEO
 * 
 * @param content - Contenido de la sección
 * @returns Objeto con metadatos de SEO
 */
export function getSEOMetadata(content: SectionContent | null) {
  return {
    title: content?.metadata?.seo_title || content?.title || '',
    description: content?.metadata?.seo_description || content?.description || '',
    ogImage: content?.metadata?.og_image || '',
    canonical: content?.metadata?.canonical || '',
  };
}

/**
 * Obtener bloque como JSON (para bloques de tipo json)
 * 
 * @param content - Contenido de la sección
 * @param blockKey - Clave del bloque
 * @returns Objeto parseable o null
 * 
 * @example
 * const team = getJSONBlock(content, 'team_members');
 */
export function getJSONBlock(
  content: SectionContent | null,
  blockKey: string
): Record<string, any> | null {
  const block = content?.blocks?.[blockKey];

  if (!block || block.type !== 'json') {
    return null;
  }

  try {
    return JSON.parse(block.content);
  } catch {
    console.error(`Error parseando bloque JSON '${blockKey}'`);
    return null;
  }
}

/**
 * Verificar si el contenido está actualizado
 * 
 * @param content - Contenido de la sección
 * @param maxAgeMinutes - Edad máxima en minutos (por defecto 60)
 * @returns true si el contenido es reciente
 */
export function isContentFresh(
  content: SectionContent | null,
  maxAgeMinutes: number = 60
): boolean {
  if (!content?.updated_at) {
    return false;
  }

  const updateTime = new Date(content.updated_at).getTime();
  const now = Date.now();
  const ageMinutes = (now - updateTime) / (1000 * 60);

  return ageMinutes <= maxAgeMinutes;
}

/**
 * Sanitizar contenido HTML (básico)
 * 
 * @param html - HTML a sanitizar
 * @returns HTML sanitizado
 */
export function sanitizeHTML(html: string): string {
  if (typeof document === 'undefined') {
    // En SSR, usar una librería como sanitize-html
    return html;
  }

  const temp = document.createElement('div');
  temp.textContent = html;
  return temp.innerHTML;
}
