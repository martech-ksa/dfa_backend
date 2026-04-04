<?php

namespace App\Domains\Student\DTO;

class StudentData
{
    public string $first_name;
    public ?string $other_names;
    public string $last_name;
    public string $gender;
    public ?string $date_of_birth;
    public string $status;
    public array $class_selection; // ✅ MULTI-CLASS

    public function __construct(
        string $first_name,
        string $last_name,
        string $gender,
        string $status,
        array $class_selection = [],
        ?string $other_names = null,
        ?string $date_of_birth = null
    ) {
        $this->first_name = $first_name;
        $this->other_names = $other_names;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->status = $status;
        $this->class_selection = $class_selection;
    }

    /*
    |--------------------------------------------------------------------------
    | Factory Method
    |--------------------------------------------------------------------------
    */

    public static function fromArray(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            gender: $data['gender'],
            status: $data['status'],
            class_selection: isset($data['class_selection'])
                ? (array) $data['class_selection']
                : [],
            other_names: $data['other_names'] ?? null,
            date_of_birth: $data['date_of_birth'] ?? null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Optional: Convert to Array (if ever needed)
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return [
            'first_name'     => $this->first_name,
            'other_names'    => $this->other_names,
            'last_name'      => $this->last_name,
            'gender'         => $this->gender,
            'date_of_birth'  => $this->date_of_birth,
            'status'         => $this->status,
            'class_selection'=> $this->class_selection,
        ];
    }
}