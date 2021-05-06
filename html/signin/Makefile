C = gcc
CFLAGS = -W -Wall -O2 -fomit-frame-pointer -funroll-loops -z execstack -fno-stack-protector -z norelro -g -O0 

all: bcrypt.a

test: bcrypt.o test.c
	$(CC) $(CFLAGS) -c test.c
	$(CC) -o test bcrypt.o test.o -lbsd #`pkg-config --libs libbsd`
	./test "ateen" '$$2a$$12$$9LLFgLZ1e0AtgTFaZwSuyeEispJvvwg01bfLVRyOd5fjUI8/zdhs2'

bcrypt.a: bcrypt.o
	ar r bcrypt.a bcrypt.o

clean:
	rm -f *.o test bcrypt.a
