# Heart Disease Detection

**Author:** Cojocaru Iulia-Alexandra  
**Description:** This project tackles the problem of detecting patients with heart disease using a binary classification model based on medical data. The project employs preprocessing techniques, dimensionality reduction with PCA, and classification with SVC.

## Dataset Description
The dataset includes information about over 300 patients, with each row containing the following features:
- `age`: Patient's age (years)
- `sex`: Patient's sex (1 = male, 0 = female)
- `cp`: Chest pain type (discrete values: 1, 2, 3, 4)
- `trestbps`: Resting blood pressure (mm Hg)
- `chol`: Serum cholesterol level (mg/dl)
- `fbs`: Fasting blood sugar (> 120 mg/dl is 1, otherwise 0)
- `restecg`: Resting electrocardiographic results (discrete values: 0, 1, 2)
- `thalach`: Maximum heart rate achieved (bpm)
- `exang`: Exercise-induced angina (1 = yes, 0 = no)
- `oldpeak`: ST depression induced by exercise relative to rest
- `slope`: Slope of the ST segment (discrete values: 1, 2, 3)
- `ca`: Number of major vessels colored by fluoroscopy (0-3)
- `thal`: Thalassemia defects (discrete values: 3 = normal, 6 = fixed defect, 7 = reversible defect)

The original dataset includes a `num` column, which was transformed into a binary variable `target`:
- 0: No disease
- 1: Disease present

## Data Preprocessing
1. Removing rows with missing values.
2. Transforming the `num` column into a binary variable `target`.
3. Splitting the data into features (`X`) and labels (`y`), and into training and testing sets.
4. Normalizing the data using `StandardScaler`.

## Dimensionality Reduction with PCA
**Principal Component Analysis (PCA)** was used to:
- Increase the model's training speed.
- Eliminate collinearity between features.
- Reduce the data to a lower-dimensional space while preserving essential information.

## Classification Using SVC
**Support Vector Classifier (SVC)** was employed for binary classification. Advantages of SVC include:
- Separating data categories using a hyperplane.
- Supporting non-linear kernels (e.g., RBF).

Tested kernels:
- `rbf`: Provided the best accuracy for both original and reduced data.
- `linear` and `sigmoid`: Slightly lower performance in some cases.

## Model Evaluation
The model was evaluated using:
- **Accuracy**: The proportion of correctly classified labels.
- **Confusion Matrix**: Correct and incorrect classifications.
- **Classification Report**: Precision, recall, f1-score, and support.

## Observations and Conclusions
- The `rbf` kernel yielded the best results for most data scenarios.
- Dimensionality reduction with PCA retains essential information but can slightly impact accuracy.
- Classifying patients enables quick and effective decision-making in the medical field.

## References
- [Matplotlib Documentation](https://matplotlib.org/stable/api/_as_gen/matplotlib.pyplot.scatter.html)
- [Scikit-learn Documentation](https://scikit-learn.org/1.5/modules/generated/sklearn.svm.SVC.html)
- [Heart Disease Dataset](https://archive.ics.uci.edu/dataset/45/heart+disease)
