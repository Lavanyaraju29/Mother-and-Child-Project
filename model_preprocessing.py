import pandas as pd
import numpy as np
import seaborn as sns
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error, r2_score
from sklearn.preprocessing import LabelEncoder, StandardScaler

# Load Data
def load_data(file_path):
    try:
        df = pd.read_csv(file_path)
        print("Dataset Loaded Successfully\n")
        return df
    except Exception as e:
        print(f"Error loading dataset: {e}")

# Check for Missing Values
def check_missing_values(df):
    print("Missing Values Before Cleaning:\n", df.isnull().sum(), "\n")
    df.fillna(df.mean(numeric_only=True), inplace=True)
    print("Missing Values After Cleaning:\n", df.isnull().sum(), "\n")
    return df

# Encode Categorical Columns
def encode_categorical_columns(df):
    label_encoder = LabelEncoder()
    for col in df.select_dtypes(include=['object']).columns:
        df[col] = label_encoder.fit_transform(df[col])
    print("Categorical Columns Encoded Successfully.\n")
    return df

# Plot Correlation Heatmap
def plot_heatmap(df):
    plt.figure(figsize=(12, 8))
    sns.heatmap(df.corr(), annot=True, cmap='coolwarm')
    plt.title("Correlation Heatmap")
    plt.show()

# Preprocessing
def preprocess_data(df):
    df = check_missing_values(df)
    df = encode_categorical_columns(df)
    
    # Features and Target
    X = df.drop('Risk Percentage', axis=1)
    y = df['Risk Percentage']
    scaler = StandardScaler()
    X = scaler.fit_transform(X)
    
    plot_heatmap(df)
    return X, y

# Evaluate Regression Model
def evaluate_regression(y_test, y_pred):
    print("Mean Absolute Error (MAE):", mean_absolute_error(y_test, y_pred))
    print("Mean Squared Error (MSE):", mean_squared_error(y_test, y_pred))
    print("R2 Score:", r2_score(y_test, y_pred))

# Train and Evaluate Models
def train_and_evaluate_models(X, y):
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    
    models = {
        'RandomForest': RandomForestRegressor(random_state=42),
        'LinearRegression': LinearRegression(),
    }
    
    for name, model in models.items():
        print(f"\nTraining {name} Model...")
        model.fit(X_train, y_train)
        y_pred = model.predict(X_test)
        print(f"{name} Model Evaluation:")
        evaluate_regression(y_test, y_pred)

# Main Function
if __name__ == "__main__":
    file_path = 'mother_health_data_cleaned.csv'  # Ensure this is the correct path
    df = load_data(file_path)
    if df is not None:
        X, y = preprocess_data(df)
        train_and_evaluate_models(X, y)
