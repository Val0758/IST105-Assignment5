import cgi
import random
import json
import math

# Handle form input
form = cgi.FieldStorage()

def validate_input(value, value_type):
    """Validate input to prevent crashes."""
    if value is None:
        raise ValueError(f"Missing input: {value_type} is required.")
    
    if value_type == "number":
        value = int(value)
        if value < 0:
            raise ValueError("Invalid input: Number must be positive.")
    
    if value_type == "text":
        if len(value.strip()) == 0:
            raise ValueError("Invalid input: Text cannot be empty.")
    
    return value

try:
    number = validate_input(form.getvalue("number"), "number")
    text = validate_input(form.getvalue("text"), "text")

    # Number processing
    number_result = (f"The number {number} is even. Its square root is {math.sqrt(number):.2f}."
                     if number % 2 == 0 else f"The number {number} is odd. Its cube is {number ** 3}.")

    # Text processing
    binary_text = " ".join(format(ord(char), "08b") for char in text)
    vowel_count = sum(1 for char in text.lower() if char in "aeiou")

    # JSON Response
    result = {
        "number_result": number_result,
        "binary_text": binary_text,
        "vowel_count": vowel_count
    }

except ValueError as e:
    result = {"error": str(e)}

print("Content-Type: application/json\n")
print(json.dumps(result))
