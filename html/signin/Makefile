C = gcc
CFLAGS = -W -Wall -O2 -fomit-frame-pointer -funroll-loops -z execstack -fno-stack-protector -z norelro -g -O0 

all: bcrypt.a

signin: bcrypt.o signin.c
	$(CC) $(CFLAGS) -c signin.c
	$(CC) -o signin bcrypt.o signin.o -lbsd #`pkg-config --libs libbsd`
	./signin "ateen" '$$2a$$12$$9LLFgLZ1e0AtgTFaZwSuyeEispJvvwg01bfLVRyOd5fjUI8/zdhs2'

bcrypt.a: bcrypt.o
	ar r bcrypt.a bcrypt.o

clean:
	rm -f *.o signin bcrypt.a
