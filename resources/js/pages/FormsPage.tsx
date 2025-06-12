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
    const { data, setData, post, processing, errors } = useForm({
        form_file: null,
        title: '',
        office_id: 0,
    });

    const [offices, setOffices] = useState<{ label: string; value: string | number }[]>([]);

    useEffect(() => {
        const fetchOffices = async () => {
            try {
                const response = await axios.get('/offices');
                const formatted = response.data.map((office: any) => ({
                    label: office.name,
                    value: office.id,
                }));
                setOffices(formatted);
            } catch (error) {
                console.error('Error fetching offices:', error);
            }
        };

        fetchOffices();
    }, []);

    const formTypeOptions = formTypes.map((type) => ({
        label: type.replace(/_/g, ' ').toUpperCase(),
        value: type,
    }));

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();
        try{
            const response = await axios.postForm('form/submit',data)
            console.log('Form submitted successfully:', response.data);
            alert('Form submitted successfully')

        }catch(error){
            console.error('Error submitting form:', error);
            alert('An error occured when submitting Form')

        }


    };

    console.log(data);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Student-Form" />

            <div className="mx-6 mt-6 flex flex-col gap-6 bg-[#0B1739] p-4">
                <div className="flex w-lg justify-between gap-6 border-amber-50 bg-[#0B1739] p-4">
                    <div className="">
                        <label>Form Type</label>
                        <CustomDropdown
                            options={formTypeOptions}
                            value={data.title}
                            onChange={(value) => setData('title', value)}
                            placeholder="Select a form type"
                            minWidth="100%"
                            fontHeavy
                        />
                    </div>
                    <div className="">
                        <label>Office</label>
                        <CustomDropdown
                            options={offices}
                            value={data.office_id}
                            onChange={(value) => setData('office_id', value)}
                            placeholder="Select an office"
                            minWidth="100%"
                            fontHeavy
                        />
                    </div>
                </div>
                <div className="flex w-lg justify-between gap-6">
                    <div>
                        <UploadButton onFileSelect={(file) => setData('form_file', file)} label="Upload Form File" />
                        {data.form_file && (
                            <p className="mt-1 text-sm text-white">
                                Selected: <span className="font-medium">{data.form_file.name}</span>
                            </p>
                        )}
                    </div>
                    <div>
                        <Button variant="default" size="lg" className="" onClick={submit} disabled={processing}>
                            Submit Form
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
