import CustomDropdown from '@/components/custom-dropdown';
import { Button } from '@/components/ui/button';
import UploadButton from '@/components/upload-button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import axios from 'axios';

import { FormEventHandler, useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Forms',
        href: '/form',
    },
];


const formTypes = ['course_registration', 'course_change', 'course_drop', 'course_add'];
export default function FormPage() {

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();
        try{
            const response = await axios.postForm('form/submit')
            console.log('Form submitted successfully:', response.data);

        }catch(error){
            console.error('Error submitting form:', error);


        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Office-submissions" />


        </AppLayout>
    );
}
