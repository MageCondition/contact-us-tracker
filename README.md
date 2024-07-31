# Magento 2. Contact Us Tracker

![Magento 2](https://img.shields.io/badge/Magento-2-brightgreen.svg)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/3654c6325c2d4217aefae674e622476a)](https://app.codacy.com/gh/MageCondition/contact-us-tracker/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
![License](https://img.shields.io/badge/license-OSL-blue.svg)

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

## Compatibility

- PHP 8+
- Magento Open Source (CE) 2.4.*
- Adobe Commerce (EE) 2.4.*

## Support

If you encounter any issues or have questions regarding the module, please open an issue on the [GitHub repository](https://github.com/MageCondition/contact-us-tracker).

You can also reach us via email at [wincondition2911@gmail.com](mailto:wincondition2911@gmail.com).

## License

This module is licensed under the Open Software License (OSL). See the [LICENSE](https://github.com/MageCondition/contact-us-tracker/blob/main/LICENSE.txt) file for more details.
