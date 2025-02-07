import cgi
import random
import json
import math

# Handle form input
form = cgi.FieldStorage()
number = int(form.getvalue("number"))
text = form.getvalue("text")

# Number processing
if number % 2 == 0:
    number_result = f"The number {number} is even. Its square root is {math.sqrt(number):.2f}."
else:
    number_result = f"The number {number} is odd. Its cube is {number ** 3}."

# Text processing
binary_text = " ".join(format(ord(char), "08b") for char in text)
vowel_count = sum(1 for char in text.lower() if char in "aeiou")

# Treasure Hunt Game
secret_number = random.randint(1, 100)
attempts = []
found = False
for attempt in range(1, 6):
    guess = random.randint(1, 100)
    attempts.append(f"Attempt {attempt}: {guess}")
    if guess == secret_number:
        found = True
        break

if found:
    treasure_result = f"You found the treasure in {attempt + 1} attempts!"
else:
    treasure_result = f"You failed to find the treasure. The secret number was {secret_number}."

# JSON Response
result = {
    "number_result": number_result,
    "binary_text": binary_text,
    "vowel_count": vowel_count,
    "treasure_result": treasure_result,
    "attempts": attempts
}

print("Content-Type: application/json\n")
print(json.dumps(result))
