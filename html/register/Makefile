CC = gcc
CFLAGS = -W -Wall -O2 -fomit-frame-pointer -funroll-loops -z execstack -fno-stack-protector -z norelro -g -O0 

all: bcrypt.a

register: bcrypt.o register.c
	$(CC) $(CFLAGS) -c register.c
	$(CC) $(CFLAGS) -o register bcrypt.o register.o -lbsd #`pkg-config --libs libbsd`
	./register "ateen"

bcrypt.a: bcrypt.o
	ar r bcrypt.a bcrypt.o

clean:
	rm -f *.o register bcrypt.a
