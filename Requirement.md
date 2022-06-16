INTRODUCTION
This test is designed to estimate a candidate's ability to learn and implement Drupal 8 APIs. 
A candidate will be asked for an explanation of written code and should demonstrate a strong understanding of concepts and techniques used during implementing a technical test.

API USED
During this task a candidate should understand and implement techniques:
●	“Middleware API”
●	“Configuration API”.


TECHNICAL DESCRIPTION
●	done--Each user should have a new field called “AUTH TOKEN”. The field should contain a 32-digits random token, 
        done--which should be generated upon user creation.
●	done--On site load, the candidate’s code should look at the specific parameter in URL “authtoken” (www.example.com?authtoken=”[TOKEN HERE]”) 
        done(not working) --and if a token exists, the user, that has such a token, should be authenticated.
●	done--The task should be implemented as a drupal module deployed to a GitHub account.
●	done--Once installed, the module should create the described field for the user, tokens should be generated for all the existing users.
●	done--The module should be compatible with Drupal core version ^9.3.
RESTRICTIONS
The task should be executed within 7 days after receiving it.


