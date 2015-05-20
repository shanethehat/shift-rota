Feature: Highlight availability
  In order to avoid being allocated shifts at unsuitable times
  As an engineer
  I want to specify which shifts I am not available for

  Background:
    Given there is a schedule for a future month
    And there is an engineer called "Bob"

  Scenario: Engineer is not available for a shift
    Given Bob is part of the new month schedule
    And there is a shift Bob has not declined
    When Bob says that he cannot do a shift
    Then Bob will be flagged as unavailable for that shift

  Scenario: Engineer cancels unavailability
    Given that Bob has mistakenly said he cannot do a shift
    When Bob says that he is available for that shift
    Then Bob will be flagged as available for that shift
