@extends('layouts.admin')

@section('content')
    <livewire:admin.students.profile :student="$student" />
@endsection
