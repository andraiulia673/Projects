# Lung Image Reconstruction for Anomaly Detection

## Overview

This project explores the use of deep learning for **masked medical image reconstruction**, with the goal of recovering missing information from lung CT images. The approach is based on a **U-Net architecture** trained to reconstruct original lung images from artificially masked inputs.

The project uses a subset derived from the **Lung Image Database Consortium – Image Database Resource Initiative (LIDC-IDRI)** dataset. The reconstruction process is designed to be **independent of labeled anomaly data**, making it a potentially useful approach for subsequent medical image analysis tasks such as anomaly detection and segmentation.

## Dataset

The experimental dataset contains:

* **1,359 lung CT images**
* Images from **100 patients** selected from LIDC-IDRI
* Grayscale images with an original resolution of **512 × 512 pixels**
* Images resized to **256 × 256 pixels**
* Normalized pixel values in the range **[0, 1]**
* **815 images** for training
* **136 images** for validation
* **408 images** for testing

## Preprocessing and Masking

The preprocessing pipeline consists of image normalization and resizing using bilinear interpolation.

Before masking, the lung regions are isolated from the background using:

* Canny Edge Detection
* OpenCV-based filling operations
* Binary lung masks

The lung region is assigned a value of 1, while the background is assigned 0.

Random rectangular regions are then removed from the lung area by setting their pixel values to zero. The position and dimensions of the masked regions are randomly selected while remaining within the lung region.

## Model Architecture

The reconstruction model is based on **U-Net**, using an encoder-decoder architecture with skip connections.

* **Encoder:** extracts features while progressively reducing spatial resolution.
* **Skip connections:** transfer high-resolution intermediate features between corresponding encoder and decoder stages.
* **Decoder:** reconstructs the image by combining learned representations with fine-grained spatial information.

The model receives a masked image as input and uses the corresponding original preprocessed image as the reconstruction target. The network learns to predict the missing image content.

## Loss Functions

Several training strategies were investigated.

### 1. MSE Loss

Mean Squared Error (MSE) is used to compare the reconstructed image with the original target at pixel level.

### 2. Combined MSE + SSIM Loss

A combined loss function was implemented by interpolating MSE and SSIM:

```text
L = α · L_MSE + (1 − α) · (1 − L_SSIM)
```

The coefficient **α** controls the contribution of the two components, allowing the balance between pixel-level accuracy and structural similarity to be investigated.

Experiments were performed using different α values to study their influence on reconstruction quality.

### 3. Sequential MSE + SSIM Training

A second training strategy uses the two metrics sequentially. The model is first trained using MSE, after which the best MSE model is loaded and further experiments are performed using SSIM.

## Training

During training:

1. Masked images are provided as inputs.
2. Original preprocessed images are used as targets.
3. The predicted reconstruction is compared against the target.
4. MSE and/or SSIM-based losses are used to penalize reconstruction differences.
5. The model is validated every two epochs.
6. The best-performing model is saved in the cloud.

## Results

The experiments investigate three reconstruction strategies:

* U-Net trained with **MSE**
* U-Net trained with a **combined MSE + SSIM loss**
* Sequential training using **MSE followed by SSIM**

The experiments show that both MSE and SSIM can produce good reconstruction results under appropriate conditions. The combined approach allows the influence of the α coefficient on reconstruction quality to be investigated.

The best reconstruction model can potentially be used as a starting point for further tasks such as **lung image segmentation or anomaly detection**.

## Technologies

* Python
* PyTorch
* U-Net
* NumPy
* OpenCV
* Medical Image Processing
* Deep Learning
* MSE
* SSIM

## Key Concepts

**Masked Image Reconstruction · U-Net · Medical Imaging · Deep Learning · Image Inpainting · MSE · SSIM · LIDC-IDRI · Anomaly Detection**

## Project Objective

The main objective of the project is to investigate whether a neural network can learn to reconstruct missing information in lung CT images and whether reconstruction quality can be influenced by different loss-function strategies, without requiring labeled anomaly data.
