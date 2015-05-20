Feature: View shift schedule
  In order to manage my personal time
  As an engineer
  I want to be able to view thw shift schedule

  Background:
    Given there are several months of schedules
    And there is an engineer called "Bob"

  Scenario: View a list of months
    Given Bob is able to access the system
    When Bob requests a list of months
    Then he should see a list of months that have a schedule

  Scenario: View availability schedule for a specific month
    Given Bob is able to access the system
    When Bob requests the shift schedule for a specific month
    Then he should see the schedule for the specific month

  Scenario: View availability schedule for the current month
    Given Bob is able to access the system
    When Bob requests the shift schedule for the current month
    Then he should see the schedule for the current month
