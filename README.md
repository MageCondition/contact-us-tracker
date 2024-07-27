# Contact Us Tracker for Magento 2

![Magento 2](https://img.shields.io/badge/Magento-2-brightgreen.svg)
![License](https://img.shields.io/badge/license-MIT-blue.svg)

## Overview

**Contact Us Tracker** is a Magento 2 module that records all data from the Contact Us form and makes it accessible in the back-office (admin panel). This module helps administrators to track and manage customer inquiries efficiently.

## Features

- Record all data submitted through the Contact Us form.
- View recorded data in a convenient grid interface.
- Grid path: `MageCondition -> Contact Us Tracker -> List`

## Installation

Follow these steps to install the module:

1. **Require the module via Composer**

    ```bash
    composer require mage-condition/contact-us-tracker
    ```


2. **Run Magento setup upgrade**

    ```bash
    php bin/magento setup:upgrade
    ```

3. **Clear the cache**

    ```bash
    php bin/magento cache:clean
    ```

## Usage

1. Navigate to `MageCondition -> Contact Us Tracker -> List` in the Magento admin panel.
2. View and manage the data submitted through the Contact Us form.

## Support

If you encounter any issues or have questions regarding the module, please open an issue on the [GitHub repository](https://github.com/MageCondition/contact-us-tracker).

You can also reach us via email at [wincondition2911@gmail.com](mailto:wincondition2911@gmail.com).

## License

This module is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
