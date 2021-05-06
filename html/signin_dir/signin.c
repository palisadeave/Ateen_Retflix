// signin only

#include <string.h>
#include <stdio.h>
#include "bcrypt.h"
#include <stdlib.h>
#include <assert.h>


int main(int argc, char** argv)
{
    
    char outhash[BCRYPT_HASHSIZE];
    char inputPW[26];
    int value = 3;
    char storedPW[BCRYPT_HASHSIZE];
	// argv[2] is one-way hashed password stored in DB
	// argv[1] is plain password typed in by user
	strlcpy(inputPW, argv[1], 26);
	strlcpy(storedPW, argv[2], 61);

	// verifies whether the password matches
    value = bcrypt_hashpw(inputPW, storedPW, outhash);
    
	// anything printed by this program will be the return value and will be used in php
    if (value != 0) { 
	// bcrypt_hashpw() failed. 2 will indicate that verifying has failed
        value = 2;
        printf("%d", value);
        return 0;
    }  else {
        
        if (strcmp(storedPW, outhash) == 0) {// if result of bcrypt_hashpw() matches the storedPW it means that the password matches
	// 0 will indicate that verifying succeeded
            value = 0;
            
        } else {
		// if storedPW and outhash are not identical password does not match
            //The password does NOT match. Wrong password
            value = 1;
        }
        printf("%d", value);
        return 0;
    }
}

