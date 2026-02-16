export interface User {
  id: number;
  name: string;
  email: string;
  rol: string;  // Puede ser 'admin' o 'usu'
  activo: number;  // 0 o 1
  email_verified_at?: string | null;
  created_at: string;
  updated_at: string;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface LoginResponse {
  message: string;
  access_token: string;
  token_type: string;
  user: User;
}

export interface CreateUserRequest {
  name: string;
  email: string;
  password: string;
  rol: string;
}

export interface UpdateUserRequest {
  name?: string;
  email?: string;
  password?: string;
  rol?: string;
  activo?: number;
}

export interface ApiResponse<T> {
  success: boolean;
  message?: string;
  data?: T;
  errors?: any;
}