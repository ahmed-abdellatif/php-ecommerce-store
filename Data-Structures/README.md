# **Data Structures**

PHP is used for simple applications as well as very complex ones. Some of these applications can be  very data intensive. With the new release of PHP 7, PHP has entered into new possibilities of efficient and robust application development. Our purpose will be to show and prepare ourselves to understand the power of data structures and algorithms using PHP 7, so that we can utilize it in our applications and programs.

# **Standard PHP Library (SPL) and Data Structures**

SPL provides a set of standard data structures through Object-Oriented Programming in PHP. The supported data structures are:

**Doubly linked lists**: It is implemented in SplDoublyLinkedList.

**Stack**: It is implemented in SplStack by using SplDoublyLinkedList

**Queue**: It is implemented in SplQueue by using SplDoublyLinkedList.

**Heaps**: It is implemented in SplHeap. It also supports max heap in SplMaxHeap and min heap in SplMinHeap.

**Priority queue**: It is implemented in SplPriorityQueue by using SplHeap.
Arrays: It is implemented in SplFixedArray for a fixed size array.

**Map**: It is implemented in SplObjectStorage.



# **Abstract Data Type (ADT)**
PHP has eight primitive data types and those are booleans, integer, float, string, array, object, resource, and null. It's important to remember that PHP is a *weakly typed language* and that we are not bothered about the data type declaration while creating those. Though PHP has some static type features, PHP is predominantly a dynamically typed language which means variables are not required to be declared before using it. We can assign a value to a new variable and use it instantly.

Ultimately, abstract data types (ADT) are mathematical models for data types.

## Common ADTs
1. List
2. Map
3. Set
4. Stack
5. Queue
6. Priority Queue
7. Graph
8. Tree

# **Different Data Structures**

## Linear Data Structures
In linear data structures, items are structured in a linear or sequential manner. Array, list, stack, and queue are examples of linear structures.

## Nonlinear Data Structures
In nonlinear structures, data are not structured in a sequential way. Graph and tree are the most common examples of nonlinear data structures.

# **Algorithmic Approaches for Devising Solutions**
An algorithm is a step by step process which defines the set of instructions to be executed in a certain order to get a desired output. In general, algorithms are not limited to any programming language or platform. They are independent of programming languages. An algorithm must have the following characteristics:
* **Input**: An algorithm must have well-defined input. It can be 0 or more inputs.
* **Output**: An algorithm must have well-defined output. It must match the desired output.
* **Precision**: All steps are precisely defined.
* **Finiteness**: An algorithm must stop after a certain number of steps. It should not run indefinitely.
* **Unambiguous**: An algorithm should be clear and should not have any ambiguity in any of the steps.
* **Independent**: An algorithm should be independent of any programming language or platforms.

# **Algorithm Analysis**
We can do algorithm analysis in two different stages. One is done before implementation and one after the implementation. The analysis we do before implementation is also known as theoretical analysis and we assume that other factors such as processing power and spaces are going to be constant. The after implementation analysis is known as empirical analysis of an algorithm which can vary from platform to platform or from language to language. In empirical analysis, we can get solid statistics from the system regarding time and space utilization.

## Calculating the Complexity

* **Time complexity**: Time complexity is measured by the number of key operations in the algorithm. In other words, time complexity quantifies the amount of time taken by an algorithm from start to finish.

* **Space complexity**: Space complexity defines the amount of space (in memory) required by the algorithm in its life cycle. It depends on the choice of data structures and platforms

## Finding Case Scenarios

* **Best case**: Best case indicates the minimum time required to execute the program. For our example algorithm, the best case can be that, for each book, we are only searching the first item. So, we end up searching for a very little amount of time. We use Ω notation (Sigma notation) to indicate the best case scenario.

* **Average case**: It indicates the average time required to execute a program. For our algorithm the average case will be finding the books around the middle of the list most of the time, or half of the time they are at the beginning of the list and the remaining half are at the end of the list.

* **Worst case**: It indicates the maximum running time for a program. The worst case example will be finding the books at the end of the list all the time. We use the O (big oh) notation to describe the worst case scenario. For each book searching in our algorithm, it can take O(n) running time. From now on, we will use this notation to express the complexity of our algorithm.
