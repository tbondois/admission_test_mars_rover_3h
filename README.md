ADMISSION TEST : MARS ROVER
=================

  - [INSTRUCTIONS](#instructions)
    - [Time limit](#time-limit)
    - [Overview](#overview)
    - [Notes:](#notes)
    - [Specification](#specification)
      - [Input:](#input)
      - [Output:](#output)
    - [Example](#example)
  - [PREREQUISITES](#prerequisites)
  - [INSTALLATION](#installation)
  - [USAGE](#usage)
  

INSTRUCTIONS
-----------------

### Time limit

3 hours.

### Overview


Purpose of this challenge is to enable you to demonstrate your proficiency in solving problems
using software engineering tools and processes. Read the specification below and produce a
solution.
The problem specified below requires a solution that receives input, does some processing and
then returns some output. You are free to implement any mechanism for feeding input into your
solution. You should provide sufficient evidence that your solution is complete by, as a
minimum, indicating that it works correctly against the supplied test data. Using a unit testing
framework would satisfy these requirements.

You will be scored based on the following criteria:
- Your ability to read and interpret the specification below.
- The architectural design of your solution.
- The readability of your code.
- Your overall approach to this exercise.

### Notes:

- Database usage is not required.
- Usage of PHP version >= 5.3 is required.

###  Specification

A squad of robotic rovers is to be landed by NASA on a plateau on Mars.
This plateau, which is curiously rectangular, must be navigated by the rovers so that their on
board cameras can get a complete view of the surrounding terrain to send back to Earth.
A rover's position is represented by a combination of an x and y co-ordinates and a letter
representing one of the four cardinal compass points. The plateau is divided up into a grid to
simplify navigation. An example position might be 0, 0, N, which means the rover is in the
bottom left corner and facing North.
In order to control a rover, NASA sends a simple string of letters. The possible letters are 'L', 'R'
and 'M'. 'L' and 'R' makes the rover spin 90 degrees left or right respectively, without moving
from its current spot.
'M' means move forward one grid point, and maintain the same heading.
Assume that the square directly North from (x, y) is (x, y+1).

#### Input:

The first line of input is the upper-right coordinates of the plateau, the lower-left coordinates are
assumed to be 0,0.
The rest of the input is information pertaining to the rovers that have been deployed. Each rover
has two lines of input. The first line gives the rover's position, and the second line is a series of
instructions telling the rover how to explore the plateau.
The position is made up of two integers and a letter separated by spaces, corresponding to the
x and y co-ordinates and the rover's orientation.
Each rover will be finished sequentially, which means that the second rover won't start to move
until the first one has finished moving.

#### Output:

The output for each rover should be its final co-ordinates and heading.

### Example

```
Test input:
5 5
1 2 N
LMLMLMLMM
3 3 E
MMRMMRMRRM
Test output:
1 3 N
5 1 E
```

PREREQUISITES
-----------------
- PHP >= 7.4
- `symfony` binary ([Download and Install](https://symfony.com/download))
- `composer` binary ([Download and Install](https://getcomposer.org/download/))


INSTALLATION
-----------------
Execute theses command in a shell terminal :
```
composer install
symfony serve -d --no-tls --port=8000
```

Local HTTP server should be reachable at http://127.0.0.1:8000


USAGE
-----------------

Instructions have to be sent in Json format in HTTP POST, through POSTMAN or Curl :

Here's an example of format :

````
curl -X POST http://127.0.0.1:8000/explore -H "Content-Type: text/plain" -H "accept: text/plain" -d "
9 9
1 2 N
LMLMLMLMM
3 3 E
MMRMMRMRRM
0 0 N
MMMRMM
7 7 S
RRMMRMML
4 4 E
MMRMMLMMM
"
````

It should return :
```
1 3 N
5 1 E
2 3 E
9 9 N
9 2 E
```
