.model small
.stack 64
.data
  msj db 0ah,0dh, 'Hola Mundo','$'
.code
inicio:
  mov ax,@data
  mov ds,ax
  mov ah,09h
  mov dx,offset msj
  int 21h

Salir:
mov ah,04ch
int 21h

end