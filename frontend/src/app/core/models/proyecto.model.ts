export interface Proyecto {
  id: number;
  nombre: string;
  resumen: string;
  descripcion: string;
  curso: string;
  alumnos: string[];
  video_url: string;
  documentos: string[] | null;  // Array o null
  tags: string[] | null;        // Array o null
  checked: boolean;
  observaciones: string | null;
  created_at: string;
  updated_at: string;
}

export interface CreateProyectoRequest {
  nombre: string;
  resumen: string;
  descripcion: string;
  curso: string;
  alumnos: string[];
  video_url: string;
  documentos?: string[];
  tags?: string[];
  checked?: boolean;
  observaciones?: string | null;
}

export interface UpdateProyectoRequest {
  nombre?: string;
  resumen?: string;
  descripcion?: string;
  curso?: string;
  alumnos?: string[];
  video_url?: string;
  documentos?: string[];
  tags?: string[];
  checked?: boolean;
  observaciones?: string | null;
}