import { useEffect, useState } from 'react';
import { API_ENDPOINTS } from '../../config/api';

export default function TestimoniosReact() {
  const [data, setData] = useState(null);

  useEffect(() => {
    const loadData = async () => {
      try {
        console.log(`[Testimonios] Conectando a: ${API_ENDPOINTS.testimonios}`);
        const res = await fetch(API_ENDPOINTS.testimonios);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const json = await res.json();
        console.log('[Testimonios] ✓ Éxito cargando datos');
        setData(json);
      } catch (err) {
        console.error('Error loading testimonios:', err);
        setData({ blocks: {}, images: [] });
      }
    };
    loadData();
  }, []);

  const blocks = data?.blocks || {};
  const images = data?.images || [];

  const getImageUrl = (id) => {
    if (!id) return '';
    const img = images.find(i => i.id == id);
    return img?.url || '';
  };

  const badge = blocks.section_badge?.content || 'TESTIMONIOS';
  const t1p1 = blocks.titulo_parte1?.content || 'Lo que Dicen';
  const t1p2 = blocks.titulo_parte2?.content || 'Nuestras Pacientes';
  const desc = blocks.descripcion?.content || 'Opiniones reales de nuestras redes sociales sobre la calidez y el profesionalismo que nos define.';
  const ctaLink = blocks.cta_button_url?.content || 'https://www.facebook.com/jyza.cmeg';

  const testimonios = [
    {
      selector: 'card-marianela',
      defaultImg: '/marianela.webp',
      img: getImageUrl(blocks.testimonio1_avatar?.content),
      name: blocks.testimonio1_name?.content || 'Marianela A.',
      tag: blocks.testimonio1_tag?.content || 'Paciente verificada',
      text: blocks.testimonio1_text?.content || '"100% recomendado. En el Consultorio Ginecológico JYZA me atendieron de lo mejor, muchas gracias 🥺🥺"',
      likes: blocks.testimonio1_likes?.content || '124',
      classes: 'testimony-card small accent card-marianela'
    },
    {
      selector: 'card-kharito',
      defaultImg: '/karito.webp',
      img: getImageUrl(blocks.testimonio2_avatar?.content),
      name: blocks.testimonio2_name?.content || 'Kharitto P.',
      tag: blocks.testimonio2_tag?.content || 'Paciente',
      text: blocks.testimonio2_text?.content || '"100% garantizado y con excelente atención de principio a fin 🙏🏼"',
      classes: 'testimony-card small muted card-kharito'
    },
    {
      selector: 'card-anonima',
      img: getImageUrl(blocks.testimonio8_avatar?.content),
      name: blocks.testimonio8_name?.content || 'Paciente Anónima',
      tag: blocks.testimonio8_tag?.content || 'Paciente',
      text: blocks.testimonio8_text?.content || '"Puntualidad y limpieza impecable. Sin duda el mejor consultorio ginecológico."',
      classes: 'testimony-card small accent muted card-anonima'
    },
    {
      selector: 'card-carol',
      defaultImg: '/cori.webp',
      img: getImageUrl(blocks.testimonio3_avatar?.content),
      name: blocks.testimonio3_name?.content || 'Cori D. R.',
      tag: blocks.testimonio3_tag?.content || 'Paciente verificada',
      text: blocks.testimonio3_text?.content || '"El mejor Dr. Jesús Caycho. Top 1."',
      likes: blocks.testimonio3_likes?.content || '11',
      classes: 'testimony-card mini-top card-carol'
    },
    {
      selector: 'card-fiorella',
      defaultImg: '/fiorella.webp',
      img: getImageUrl(blocks.testimonio4_avatar?.content),
      name: blocks.testimonio4_name?.content || 'Fiorella B.',
      tag: blocks.testimonio4_tag?.content || 'Paciente embarazo de alto riesgo',
      text: blocks.testimonio4_text?.content || '" Siempre estaré muy agradecida por cómo cuidaron de mí y de mi bebé en un momento muy difícil de mi embarazo de riesgo. Gracias por todo su apoyo, ahora mi bebé ya cumplió un año gracias a Dios ❤️🙏"',
      classes: 'testimony-card featured card-fiorella',
      featured: true
    },
    {
      selector: 'card-angelica',
      defaultImg: '/angelica.webp',
      img: getImageUrl(blocks.testimonio5_avatar?.content),
      name: blocks.testimonio5_name?.content || 'Angélica M. A. M. F.',
      tag: blocks.testimonio5_tag?.content || 'Paciente postoperatoria',
      text: blocks.testimonio5_text?.content || '"Muchas gracias doctores, mi recuperación está siendo exitosa hasta el momento."',
      classes: 'testimony-card small accent card-angelica',
      hasRating: true
    },
    {
      selector: 'card-leydi',
      defaultImg: '/leydi.webp',
      img: getImageUrl(blocks.testimonio6_avatar?.content),
      name: blocks.testimonio6_name?.content || 'Leydi J.',
      tag: blocks.testimonio6_tag?.content || 'Paciente',
      text: blocks.testimonio6_text?.content || '"100% recomendado, excelente atención."',
      classes: 'testimony-card small card-leydi'
    },
    {
      selector: 'card-daniela',
      defaultImg: '/daniela.webp',
      img: getImageUrl(blocks.testimonio7_avatar?.content),
      name: blocks.testimonio7_name?.content || 'Daniela D. S.',
      tag: blocks.testimonio7_tag?.content || 'Paciente',
      text: blocks.testimonio7_text?.content || '"Súper recomendado. 🤗🤗 Excelente atención!"',
      classes: 'testimony-card small accent card-daniela'
    }
  ];

  return (
    <section className="testimonials-section">
      <div className="container">
        {/* Header */}
        <div className="section-header">
          <div className="section-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
              <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            {badge}
          </div>
          <h2 className="section-title">
            {t1p1} <span className="highlight">{t1p2}</span>
          </h2>
          <div className="title-line"></div>
          <p className="section-subtitle">{desc}</p>
        </div>

        {/* Mosaic grid */}
        <div className="mosaic-grid">
          {/* Columna izquierda */}
          <div className="col col-left">
            {testimonios.slice(0, 3).map((t, idx) => (
              <div key={idx} className={t.classes}>
                <div className="card-header">
                  {t.selector === 'card-anonima' ? (
                    <div className="avatar avatar-icon anon">👤</div>
                  ) : (
                    <div className="avatar avatar-img">
                      <img src={t.img || t.defaultImg} alt={t.name} loading="lazy" width="60" height="60" />
                    </div>
                  )}
                  <div className="user-info">
                    <span className="user-name">{t.name}</span>
                    <span className="user-tag">{t.tag}</span>
                  </div>
                </div>
                <p className="card-text">{t.text}</p>
                {t.likes && (
                  <div className="card-footer">
                    <span className="likes">♡ {t.likes}</span>
                  </div>
                )}
              </div>
            ))}
          </div>

          {/* Columna central (featured) */}
          <div className="col col-center">
            {testimonios.slice(3, 5).map((t, idx) => (
              <div key={idx} className={t.classes}>
                <div className="card-header">
                  <div className={`avatar avatar-img ${t.featured ? 'large' : ''}`}>
                    <img src={t.img || t.defaultImg} alt={t.name} loading="lazy" width={t.featured ? 100 : 60} height={t.featured ? 100 : 60} />
                  </div>
                  <div className="user-info">
                    <span className="user-name">{t.name}</span>
                    <span className="user-tag">{t.tag}</span>
                  </div>
                  {t.featured && <span className="dots">···</span>}
                </div>
                <p className={`card-text ${!t.featured ? 'small-text' : ''}`}>{t.text}</p>
                {t.featured && (
                  <>
                    <div className="card-stars">
                      <span>⭐ Excelentes profesionales</span>
                      <span>⭐ Excelente calidad humana en el Consultorio Ginecológico JYZA.</span>
                    </div>
                    <div className="card-actions">
                      <span>♡</span><span>💬</span><span>↗</span>
                      <span className="bookmark">🔖</span>
                    </div>
                  </>
                )}
                {!t.featured && t.likes && (
                  <div className="card-footer">
                    <span className="likes">♡ {t.likes}</span>
                  </div>
                )}
              </div>
            ))}
          </div>

          {/* Columna derecha */}
          <div className="col col-right">
            {testimonios.slice(5).map((t, idx) => (
              <div key={idx} className={t.classes}>
                <div className="card-header">
                  <div className="avatar avatar-img">
                    <img src={t.img || t.defaultImg} alt={t.name} loading="lazy" width="60" height="60" />
                  </div>
                  <div className="user-info">
                    <span className="user-name">{t.name}</span>
                    <span className="user-tag">{t.tag}</span>
                  </div>
                </div>
                <p className="card-text">{t.text}</p>
                {t.hasRating && <div className="card-rating">★★★★★</div>}
              </div>
            ))}
          </div>
        </div>

        {/* CTA */}
        <div className="cta-wrapper">
          <a href={ctaLink} className="btn-cta" target="_blank" rel="noopener noreferrer">
            VER MÁS TESTIMONIOS
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </div>
      </div>

      <style>{`
        .testimonials-section {
          padding: 5rem 0;
          background: radial-gradient(ellipse at top, #1e0a2e 0%, #120318 60%, #0d0118 100%);
          overflow: hidden;
        }

        .container {
          max-width: 1100px;
          margin: 0 auto;
          padding: 0 2rem;
        }

        .section-header {
          text-align: center;
          margin-bottom: 3.5rem;
        }

        .section-badge {
          display: inline-flex;
          align-items: center;
          gap: 0.5rem;
          padding: 0.4rem 1.2rem;
          border: 1px solid rgba(168, 85, 247, 0.6);
          border-radius: 50px;
          color: #DA7FFF;
          font-size: 0.72rem;
          font-weight: 600;
          letter-spacing: 1.5px;
          margin-bottom: 1.25rem;
        }

        .section-title {
          font-size: 2.5rem;
          font-weight: 700;
          color: white !important;
          margin: 0 0 0.5rem 0;
          line-height: 1.2;
        }

        .highlight { color: var(--color-violeta); }

        .title-line {
          width: 48px;
          height: 3px;
          background: var(--color-violeta);
          border-radius: 2px;
          margin: 0.75rem auto 1.25rem;
        }

        .section-subtitle {
          font-size: 0.95rem;
          color: rgba(255,255,255,0.6);
          max-width: 480px;
          margin: 0 auto;
          line-height: 1.6;
        }

        .mosaic-grid {
          position: relative;
          height: 600px;
          padding-top: 4rem;
          margin: 0 -1rem;
        }

        .col { display: contents; }

        .testimony-card {
          position: absolute;
          background: #1a1a2e;
          border: 1px solid #2d2345;
          border-radius: 16px;
          padding: 1.25rem;
          color: white;
          transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .testimony-card:hover {
          transform: translateY(-2px);
          border-color: rgba(168,85,247,0.6);
        }

        .testimony-card.muted {
          background: #141118;
          border-color: #252035;
        }

        .testimony-card.accent {
          background: #2d1b4e;
          border-color: #4a3473;
        }

        .testimony-card.featured {
          background: #270630;
          border-color: #d8b4fe;
          padding: 1.5rem;
        }

        .testimony-card.mini-top {
          padding: 1rem 1.25rem;
        }

        .card-marianela {
          left: 16%;
          top: -10%;
          width: 20%;
          transform: rotate(-1.5deg);
          z-index: 2;
        }

        .card-kharito {
          left: 4%;
          top: 33%;
          width: 25%;
          transform: rotate(0.5deg);
          z-index: 2;
        }

        .card-anonima {
          left: 11%;
          top: 68%;
          width: 21%;
          transform: rotate(-0.5deg);
          z-index: 2;
        }

        .card-carol {
          left: 37%;
          top: -8%;
          width: 22%;
          transform: rotate(-0.5deg) scale(0.85);
          z-index: 6;
          opacity: 0.8;
        }

        .card-fiorella {
          left: 32%;
          top: 16%;
          width: 33%;
          transform: rotate(-0.5deg);
          z-index: 5;
          box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .card-angelica {
          right: 10%;
          top: -3%;
          width: 24%;
          transform: rotate(-1deg);
          z-index: 2;
        }

        .card-leydi {
          right: 4%;
          top: 35%;
          width: 25%;
          z-index: 2;
        }

        .card-daniela {
          right: 11%;
          top: 66%;
          width: 22%;
          transform: rotate(0.8deg);
          z-index: 2;
        }

        .card-header {
          display: flex;
          align-items: center;
          gap: 0.75rem;
          margin-bottom: 0.875rem;
        }

        .avatar {
          width: 38px;
          height: 38px;
          border-radius: 50%;
          flex-shrink: 0;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 0.75rem;
          font-weight: 700;
        }

        .avatar.large { width: 46px; height: 46px; }

        .avatar-img img { width: 100%; height: 100%; object-fit: cover; }

        .user-info {
          display: flex;
          flex-direction: column;
          gap: 0.15rem;
          flex: 1;
          min-width: 0;
        }

        .user-name {
          font-size: 0.875rem;
          font-weight: 600;
          color: white;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }

        .user-tag {
          font-size: 0.7rem;
          color: rgba(255,255,255,0.85);
        }

        .user-tag.verified { color: #FFE135; }

        .dots {
          color: rgba(255,255,255,0.7);
          font-size: 1.1rem;
          letter-spacing: 1px;
          margin-left: auto;
          flex-shrink: 0;
        }

        .card-text {
          font-size: 0.875rem;
          line-height: 1.6;
          color: rgba(255,255,255,0.8);
          margin: 0 0 0.75rem 0;
        }

        .card-text.small-text { font-size: 0.8rem; margin-bottom: 0.5rem; }

        .card-stars {
          display: flex;
          flex-direction: column;
          gap: 0.35rem;
          margin-bottom: 1rem;
        }

        .card-stars span {
          font-size: 0.8rem;
          color: rgba(255,255,255,0.7);
        }

        .card-footer {
          display: flex;
          align-items: center;
          gap: 0.75rem;
        }

        .likes {
          font-size: 0.75rem;
          color: rgba(255,255,255,0.75);
        }

        .card-rating {
          font-size: 0.8rem;
          color: #fbbf24;
          margin-top: 0.5rem;
        }

        .card-actions {
          display: flex;
          align-items: center;
          gap: 1rem;
          font-size: 1rem;
          color: rgba(255,255,255,0.75);
        }

        .card-actions .bookmark { margin-left: auto; }

        .cta-wrapper {
          display: flex;
          justify-content: center;
          margin-top: 3rem;
        }

        .btn-cta {
          display: inline-flex;
          align-items: center;
          gap: 0.75rem;
          background: var(--color-btn-primary);
          color: white;
          padding: 1rem 2.5rem;
          border-radius: 50px;
          font-weight: 700;
          font-size: 0.875rem;
          letter-spacing: 0.5px;
          text-decoration: none;
          transition: all 0.3s ease;
        }

        .btn-cta:hover {
          background: var(--color-btn-primary-hover);
          transform: translateY(-2px);
        }

        @media (max-width: 968px) {
          .mosaic-grid {
            position: relative;
            height: auto;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding-top: 0;
          }

          .testimony-card {
            position: relative !important;
            width: 100% !important;
            left: auto !important;
            right: auto !important;
            top: auto !important;
            box-sizing: border-box;
          }

          .section-title { font-size: 1.75rem; }
        }

        @media (max-width: 640px) {
          .testimonials-section { padding: 3rem 0; }
          .section-title { font-size: 1.5rem; }
          .section-subtitle { font-size: 0.85rem; }
          .testimony-card { padding: 1rem; }
          .card-text { font-size: 0.825rem; }
        }
      `}</style>
    </section>
  );
}
