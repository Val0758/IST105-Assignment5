#!/usr/bin/env python3

import os
import cgi
import sys
import json
import random
import math

# Detect if running as CGI or from PHP shell_exec
if "REQUEST_METHOD" in os.environ:
    form = cgi.FieldStorage()
    number = form.getvalue("number")
    text = form.getvalue("text")
    guesses = [form.getvalue(f"guess{i}") for i in range(1, 6)]
else:
    if len(sys.argv) < 8:  # Needs number, text, and 5 guesses
        print("Content-Type: application/json\n")
        print(json.dumps({"error": "Missing input: number, text, and all 5 guesses are required."}))
        sys.exit(1)

    number = sys.argv[1]
    text = sys.argv[2]
    guesses = sys.argv[3:8]  # Get guesses from CLI arguments

# Function to validate input
def validate_input(value, value_type):
    if value is None or str(value).strip() == "":
        raise ValueError(f"Missing input: {value_type} is required.")

    if value_type == "number":
        try:
            value = int(value)
        except ValueError:
            raise ValueError("Invalid input: number must be an integer.")

        if value < 0:
            raise ValueError("Invalid input: number must be positive.")

    if value_type == "text" and len(value.strip()) == 0:
        raise ValueError("Invalid input: text cannot be empty.")

    return value

try:
    # Validate inputs
    number = validate_input(number, "number")
    text = validate_input(text, "text")
    guesses = [validate_input(g, "guess") for g in guesses]

    # Convert guesses to integers
    guesses = [int(g) for g in guesses]

    # Number Puzzle
    if number % 2 == 0:
        number_result = f"The number {number} is even. Its square root is {math.sqrt(number):.2f}."
    else:
        number_result = f"The number {number} is odd. Its cube is {number ** 3}."

    # Text Puzzle
    binary_text = " ".join(format(ord(char), "08b") for char in text)
    vowel_count = sum(1 for char in text.lower() if char in "aeiou")

    # Treasure Hunt (User guesses)
    secret_number = random.randint(1, 100)  # Generate secret number
    found = False
    attempt_results = []

    for attempt, guess in enumerate(guesses, start=1):
        attempt_results.append(f"Attempt {attempt}: {guess}")
        if guess == secret_number:
            found = True
            break  # Stop if correct

    # Determine treasure hunt outcome
    treasure_result = (
        f"🎉 You found the treasure in {attempt} attempts! 🎉"
        if found
        else f"❌ You failed to find the treasure. The secret number was {secret_number}."
    )

    # JSON response
    result = {
        "number_result": number_result,
        "binary_text": binary_text,
        "vowel_count": vowel_count,
        "treasure_result": treasure_result,
        "attempts": attempt_results,
    }

except ValueError as e:
    result = {"error": str(e)}

# Output JSON response
print("Content-Type: application/json\n")
print(json.dumps(result))
