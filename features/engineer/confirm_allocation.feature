Feature: Confirm allocation
  In order to ensure I only work shifts I am available for
  As an engineer
  I want to be able to confirm the shifts that are allocated to me

  Background:
    Given there is an engineer called "Bob"

  Scenario: Engineer can confirm availability
    Given that Bob is allocated a shift
    When Bob confirms he is available
    Then Bob will be confirmed for that shift

  @db
  Scenario: Engineer is unable to work the allocated shift
    Given that Bob is allocated a shift he cannot work
    And there is an administrator called "Paul"
    And there is an administrator called "John"
    When Bob flags that he is unavailable
    Then the administrators will be informed that a shift is incorrectly allocated
