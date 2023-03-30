---
name: Type Feature assignment
about: Create a new open issue was a good first issue.
title: add type 'xx' as a wrapper around yy
labels: enhancement, good first issue
assignees: ''

---

## Feature description

For the next upcoming version, I would like to see the type 'xxx' implemented. The 'xx' type will be a wrapper around the yy core function in PHP. 

You can take as short or as long as you like but all things considered, you won't have to take long (like 15 minutes most likely if you understand how the project works).

## Where will this feature be implemented

Before I start explaining how to implement your new feature I want to quickly explain that what you will be implementing is a new type of validation. Now don't worry we have a workflow for new types that make it into Redbox-Validation. Types exist in a so-called type definition class, the functions in this class represent a validation type.

Here is the sample implementation of the 'string' type in the code.

https://github.com/johnnymast/redbox-validation/blob/65f941782eccd967121d865d5fc74dd2bd2b497c/src/ValidationTypes/TypeDefinitions.php#L30-L35

You can copy and paste this example and change it for yourself. You will have to change the attribute value to what you will be implementing as a type, it might go unsaid but make sure the function name is unique. If the category of your new type does not match any existing definition class in ***src/ValidationTypes*** folder you might add a new class. If you do make sure you add your class to the defineTypes function in ***src/Validator.php***.

https://github.com/johnnymast/redbox-validation/blob/a8667ddb9a9cd4a61d2f9dc8cd866f90077ec14d/src/Validator.php#L70-L77

## What to do after your implementation 

After you have done this you will have to write a test for it in the feature test directory [winch can be found here](https://github.com/johnnymast/redbox-validation/tree/master/tests/Feature). 

## When you are done

So you are done with your implementation and the unit tests? Send me a pull request from your fork to the original project and I will take a look at your request.
