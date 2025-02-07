#Student Name: Valeria Osorio Rios
#Student ID: CT1010695
#Date: 2022-11-16
#COMPUTER SYSTEM AND ADMINISTRATION 
#Treasure Hunt is a simple web-based puzzle game where users input a number and a text string, 
# and the system processes them to generate fun and engaging results.

#IMPORT LIBRARIES 

import cgi  #	Used to handle data sent from an HTML form in a web server environment. It allows retrieving form inputs.
import random #	Used to generate random numbers.
import json #	Used to convert a dictionary into a JSON string.
import math #	Used to perform mathematical operations.
import os #	Used to interact with the operating system.

#FORM HANDLING

form = cgi.FieldStorage() #	Used to handle data sent from an HTML form in a web server environment.
number = int(form.getvalue("number")) #	Used to get the value of the "number" field from the form.
text = form.getvalue("text") #	Used to get the value of the "text" field from the form.

# NUMBER GAME

if number % 2 == 0: #	Used to check if the number is even.
    number_result = f"The number {number} is even. Its square root is {math.sqrt(number):.2f}." #	Used to calculate the square root of the number and format it to two decimal places.
else: #	Used to check if the number is odd.
    number_result = f"The number {number} is odd. Its cube is {number ** 3}." #	Used to calculate the cube of the number.

# TEXT GAME

binary_text = " ".join(format(ord(char), "08b") for char in text) #	Used to convert each character in the text into its binary representation and join them with spaces.
vowel_count = sum(1 for char in text.lower() if char in "aeiou") #	Used to count the number of vowels in the text.

# TREASURE GAME 

