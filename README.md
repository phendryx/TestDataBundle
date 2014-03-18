Configuration
---
config_test.yml

    malwarebytes_test_data:
        test_data_directory: "/TestData"
        objects:
            user:
                entity: '\Malwarebytes\TestExampleBundle\Entity\User'
                type: 'csv'
                file: 'user.csv'
            post:
                entity: '\Malwarebytes\TestExampleBundle\Entity\Post'
                type: 'csv'
                file: 'post.csv'
                mapping:
                    user:
                        entity: '\Malwarebytes\TestExampleBundle\Entity\User'
                        data_field: 'user_id'
                        property: user
                field_type:
                    date: datetime

 1. **test_data_directory** - is located in /app. Given the above example, the test_data_directory would be /app/TestData.
 2. **objects** - Your Doctrine objects you want to import data to.
     3. **entity** - The full namespace and class name of your entity.
     4. **type** - The format of the test file containing data. Currently only supports CSV files.
     5. **file** - The filename, located in test_data_directory, that contains your data.
     6. **mapping** - Associations this entity has.
         3. **entity** - The full namespace and class name of your entity.
         4. **data_field** - The field in the data file that contains your linking id.
         5. **property** - The property on this object to add this assication to.
     6. **field_type** - The type of data in this field in your file. Defaults to string. Available types are datetime. Currently 'string', 'integer', 'float' are not options, however string is the default when the field_type is not speficied.

Usage
---
This is meant to be used with MalwarebytesTestBundle. When you run your unit tests, which are based off of DoctrineTransactionTestCase, the test bundle fires an event that this bundle listens to. On that event, we import data based on the configuration settings.


