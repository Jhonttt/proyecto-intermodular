// Importaciones necesarias para pruebas unitarias en Angular
import { ComponentFixture, TestBed } from '@angular/core/testing';

// Importamos el componente que vamos a probar
import { UploadFileComponent } from './upload-file';

// Definimos un bloque de pruebas para el componente UploadFileComponent
describe('UploadFile', () => {

  // Declaramos variables que usaremos en las pruebas
  let component: UploadFileComponent; // instancia del componente
  let fixture: ComponentFixture<UploadFileComponent>; // contenedor del componente para pruebas

  // beforeEach se ejecuta antes de cada prueba
  beforeEach(async () => {
    // Configuramos el módulo de pruebas para este componente
    await TestBed.configureTestingModule({
      // Como es un componente standalone, lo importamos directamente
      imports: [UploadFileComponent]
    })
    .compileComponents(); // Compila los templates y estilos del componente

    // Creamos el fixture, que es como un "contenedor" de prueba del componente
    fixture = TestBed.createComponent(UploadFileComponent);

    // Obtenemos la instancia real del componente desde el fixture
    component = fixture.componentInstance;

    // Esperamos que todas las promesas y ciclos de detección de cambios se estabilicen
    await fixture.whenStable();
  });

  // Primera prueba: verificamos que el componente se haya creado correctamente
  it('should create', () => {
    // La expectativa es que la instancia del componente exista (no sea null o undefined)
    expect(component).toBeTruthy();
  });

  
});
