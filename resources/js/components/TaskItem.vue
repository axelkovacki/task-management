<template>
     <tr>
        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
            <slot name="title"></slot>
        </td>
        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
            <slot name="body"></slot>
        </td>
        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
            <slot name="status"></slot>
        </td>
        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
            <slot name="play-button"></slot> / 
            <slot name="edit-button"></slot> / 
            <slot name="delete-button"></slot>
        </td>
    </tr> 

</template>
