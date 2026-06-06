// Types for DOM elements
declare global {
  interface Element {
    style: CSSStyleDeclaration;
  }
  
  interface HTMLElement {
    width: number;
    height: number;
    getContext: (contextType: string) => CanvasRenderingContext2D | null;
  }
}

// Class declarations
declare class CasosExitoZoom {
  casos: NodeListOf<Element>;
  progressDots: NodeListOf<Element>;
  casosSection: Element | null;
  currentCaso: number;
  isScrolling: boolean;
  globalScrollDisabled: boolean;
  touchStartY: number;
  touchStartX: number;
  touchStartTime: number;
  hasMoved: boolean;
  
  constructor();
  init(): void;
  showCaso(index: number): void;
  handleWheel(e: WheelEvent): void;
  handleTouchStart(e: TouchEvent): void;
  handleTouchMove(e: TouchEvent): void;
}

export {};