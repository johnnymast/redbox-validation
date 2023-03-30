---
name: Feature assignment
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


## When you are done

So you are done with your implementation and the unit tests? Send me a pull request from your fork to the original project and I will take a look at your request.
