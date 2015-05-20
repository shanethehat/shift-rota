Feature: Shift changes
  In order to respond to changes in personal circumstances
  As an Engineer
  I want to be able to change my upcoming shifts

  Background:
    Given there is an engineer called "Bob"
    And there is an engineer called "Joe"
    And Bob has confirmed a shift he can no longer work
    And Joe is available for the unwanted shift

  Scenario: Engineer can request a change to a confirmed shift
    Given that Bob cannot do his confirmed shift
    And Bob requests a shift change
    Then available engineers are notified of an available shift

  Scenario: Engineer can accept a shift change request
    Given that Bob has requested a shift change
    And Joe has received the chage request
    Then Joe can accept the shift
    And the shift will no longer be allocated to Bob
    And an administrator will be notified for the change
