# AI Reordering Assistant

An AI-powered reordering assistant that analyzes retail transaction history and helps identify products that may need replenishment.

## Overview

This project explores how an AI agent can interact with business data through structured Python tools to answer customer-related questions and generate product reordering recommendations.

It uses the Online Retail dataset and combines deterministic business logic with an open-source language model.

## Key Features

- Customer order history retrieval
- Product-level reordering recommendations
- Product detail lookup
- LLM-based tool selection using Qwen2.5-1.5B-Instruct
- Input validation and tool execution
- Handling of missing or invalid customer and product IDs
- Interactive chat interface

## Architecture

1. **Retail data processing:** cleans and prepares transaction data.
2. **Business logic:** calculates order history and reordering recommendations.
3. **Python tools:** expose structured operations to the agent.
4. **LLM:** interprets requests and selects the appropriate tool.
5. **Validation layer:** checks requests and arguments before execution.
6. **User interface:** presents the results through an interactive chat.

## Tech Stack

- Python
- pandas
- Hugging Face Transformers
- Qwen2.5-1.5B-Instruct
- Gradio
- Google Colab

## Dataset

The project uses the UCI Online Retail dataset.

Dataset source: https://archive.ics.uci.edu/dataset/352/online+retail

## Limitations

- Reordering recommendations are based on historical purchasing patterns and heuristic rules.
- Stock availability is simulated rather than retrieved from a live inventory system.
- The agent suggests actions but does not automatically place orders.
- The model's tool selection and the underlying business logic are evaluated separately.

## Future Improvements

- Add automated tests and quantitative evaluation.
- Incorporate real inventory data.
- Improve reorder timing and quantity estimation.
- Compare LLM-based tool selection against a deterministic baseline.
