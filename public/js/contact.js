document.documentElement.style.overflowY = "auto";
document.body.style.overflowY = "auto";

document.getElementById("email-card").addEventListener("click", function () {
  const emailText = document.getElementById("email-text").textContent;
  copyToClipboard(emailText);
});

// Contact Page JavaScript - Form validation and interactivity
document.addEventListener("load", function () {
  const form = document.getElementById("contactForm");
  const submitBtn = document.getElementById("submitBtn");
  const messageTextarea = document.getElementById("message");
  const charCount = document.querySelector(".char-count");

  // Character counter for message field
  if (messageTextarea && charCount) {
    messageTextarea.addEventListener("input", function () {
      const length = this.value.length;
      const maxLength = 1000;
      charCount.textContent = `${length} / ${maxLength}`;

      if (length > maxLength) {
        charCount.style.color = "#c62828";
      } else if (length > maxLength * 0.9) {
        charCount.style.color = "#f57c00";
      } else {
        charCount.style.color = "#999";
      }
    });
  }

  // Real-time validation
  const inputs = form.querySelectorAll("input, textarea");
  inputs.forEach((input) => {
    input.addEventListener("blur", function () {
      validateField(this);
    });

    input.addEventListener("input", function () {
      // Clear error on input
      const errorElement = document.getElementById(`${this.id}-error`);
      if (errorElement) {
        errorElement.style.display = "none";
        errorElement.textContent = "";
      }
      this.style.borderColor = "#e0e0e0";
    });
  });

  // Form submission
  form.addEventListener("submit", function (e) {
    // Validate all fields
    let isValid = true;
    inputs.forEach((input) => {
      if (input.hasAttribute("required")) {
        if (!validateField(input)) {
          isValid = false;
        }
      }
    });

    if (!isValid) {
      e.preventDefault();
      // Scroll to first error
      const firstError = form.querySelector('.error-message[style*="block"]');
      if (firstError) {
        firstError.closest(".form-group").scrollIntoView({
          behavior: "smooth",
          block: "center",
        });
      }
      return false;
    }

    // Show loading state (let form submit naturally)
    const btnText = submitBtn.querySelector(".btn-text");
    const btnLoader = submitBtn.querySelector(".btn-loader");

    btnText.style.display = "none";
    btnLoader.style.display = "inline-block";
    submitBtn.disabled = true;

    // Form will submit naturally
  });

  function validateField(field) {
    const value = field.value.trim();
    const errorElement = document.getElementById(`${field.id}-error`);
    let errorMessage = "";

    // Required validation
    if (field.hasAttribute("required") && !value) {
      errorMessage = "This field is required.";
    }

    // Specific validations
    if (value) {
      switch (field.id) {
        case "name":
          if (value.length < 2) {
            errorMessage = "Name must be at least 2 characters.";
          }
          break;

        case "email":
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(value)) {
            errorMessage = "Please enter a valid email address.";
          }
          break;

        case "subject":
          if (value.length < 3) {
            errorMessage = "Subject must be at least 3 characters.";
          }
          break;

        case "message":
          if (value.length < 10) {
            errorMessage = "Message must be at least 10 characters.";
          } else if (value.length > 1000) {
            errorMessage = "Message must not exceed 1000 characters.";
          }
          break;
      }
    }

    // Display error or clear it
    if (errorMessage && errorElement) {
      errorElement.textContent = errorMessage;
      errorElement.style.display = "block";
      field.style.borderColor = "#c62828";
      return false;
    } else if (errorElement) {
      errorElement.style.display = "none";
      errorElement.textContent = "";
      field.style.borderColor = "#e0e0e0";
      return true;
    }

    return true;
  }
});

// Copy to clipboard functionality
function copyToClipboard(text) {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard
      .writeText(text)
      .then(function () {
        showCopyFeedback();
      })
      .catch(function (err) {
        fallbackCopyToClipboard(text);
      });
  } else {
    fallbackCopyToClipboard(text);
  }
}

function fallbackCopyToClipboard(text) {
  const textArea = document.createElement("textarea");
  textArea.value = text;
  textArea.style.position = "fixed";
  textArea.style.left = "-999999px";
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
    document.execCommand("copy");
    showCopyFeedback();
  } catch (err) {
    console.error("Failed to copy text: ", err);
  }

  document.body.removeChild(textArea);
}

function showCopyFeedback() {
  const copyBtn = event.target;
  const originalText = copyBtn.textContent;

  copyBtn.textContent = "✓ Copied!";
  copyBtn.style.background = "#00b906ff";

  setTimeout(() => {
    copyBtn.textContent = "Copy";
    copyBtn.style.background = "var(--beige)";
    copyBtn.style.color = "var(--brown-dark)";

    copyBtn.addEventListener("mouseover", function () {
      copyBtn.style.background = "var(--brown-dark)";
      copyBtn.style.color = "var(--beige)";
    });

    copyBtn.addEventListener("mouseout", function () {
      copyBtn.style.background = "var(--beige)";
      copyBtn.style.color = "var(--brown-dark)";
    });
  }, 2000);
}

// Auto-hide flash messages after 5 seconds
document.addEventListener("DOMContentLoaded", function () {
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.transition = "opacity 0.5s ease";
      alert.style.opacity = "0";
      setTimeout(() => {
        alert.remove();
      }, 500);
    }, 5000);
  });
});
