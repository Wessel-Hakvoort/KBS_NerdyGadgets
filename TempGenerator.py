#!/usr/bin/env python
# encoding: utf-8
import random
from flask import Flask
app = Flask(__name__)
@app.route('/')
def index():
    return str(round(random.uniform(2.0, 5.0), 2))
app.run()