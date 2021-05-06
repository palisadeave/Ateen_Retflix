//register only


#include <string.h>
#include <stdio.h>
#include "bcrypt.h"
#include <stdlib.h>
#include <assert.h>


int main(int argc, char** argv)
{
    char salt[BCRYPT_HASHSIZE];
    char hashedPW[BCRYPT_HASHSIZE];
    char inputPW[26];
    int returnValue;

    strcpy(inputPW, argv[1]);
	// generate salt 
    if (bcrypt_gensalt(12, salt) != 0) {
	// if process failed while generating salt, 1 will be  printed and indicate failiure in gensalt
        returnValue = 1;
        printf("%d", returnValue);
        return 0;
    }
	// one-way hash plain password
    if (bcrypt_hashpw(inputPW, salt, hashedPW) != 0) {
        returnValue = 2;
	// 2 will indicate that hashing has failed
        printf("%d", returnValue);
        return 0;
    }

    printf("%s", hashedPW);
    return 0;
}


