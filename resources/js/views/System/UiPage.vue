<template>
  <admin-layout>
    <div class="h1 mt-4 fw-bolder">Fonts</div>
    <div class="row row-cols-3">
      <div>
        <h1 class="display-1">Display 1</h1>
        <h1 class="display-2">Display 2</h1>
        <h1 class="display-3">Display 3</h1>
        <h1 class="display-4">Display 4</h1>
        <h1 class="display-5">Display 5</h1>
        <h1 class="display-6">Display 6</h1>
      </div>
      <div>
        <h1>h1. Bootstrap heading</h1>
        <h2>h2. Bootstrap heading</h2>
        <h3>h3. Bootstrap heading</h3>
        <h4>h4. Bootstrap heading</h4>
        <h5>h5. Bootstrap heading</h5>
        <h6>h6. Bootstrap heading</h6>
      </div>
      <div>
        <p>You can use the mark tag to
          <mark>highlight</mark>
          text.
        </p>
        <p>
          <del>This line of text is meant to be treated as deleted text.</del>
        </p>
        <p><s>This line of text is meant to be treated as no longer accurate.</s></p>
        <p>
          <ins>This line of text is meant to be treated as an addition to the document.</ins>
        </p>
        <p><u>This line of text will render as underlined.</u></p>
        <p><small>This line of text is meant to be treated as fine print.</small></p>
        <p><strong>This line rendered as bold text.</strong></p>
        <p><em>This line rendered as italicized text.</em></p>
      </div>
    </div>
    <div class="h1 mt-4 fw-bolder">List</div>
    <div class="mt-2">
      <ul class="level-first">
        <li>Cras justo odio</li>
        <li>Cras justo odio</li>
        <li>
          Cras justo odio
          <ul class="level-second">
            <li>Cras justo odio</li>
            <li>Cras justo odio</li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="h1 mt-4 fw-bolder">Table</div>
    <div class="mt-2">
      <div class="row">
        <div class="col-6">
          <table class="table table-bordered">
            <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td scope="row">1</td>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <td scope="row">2</td>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="col-6">
          <table class="table table-bordered">
            <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td scope="row">1</td>
              <td class="table-danger">Mark</td>
              <td>Otto</td>
              <td class="table-secondary">@mdo</td>
            </tr>
            <tr>
              <td scope="row">2</td>
              <td>Jacob</td>
              <td class="table-success">Thornton</td>
              <td>@fat</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="h1 mt-4 fw-bolder">Buttons</div>

    <div class="mt-2">
      <button type="button" class="btn btn-primary me-2">Primary</button>
      <button type="button" class="btn btn-secondary me-2">Secondary</button>
      <button type="button" class="btn btn-success me-2">Success</button>
      <button type="button" class="btn btn-danger me-2">Danger</button>
      <button type="button" class="btn btn-warning me-2">Warning</button>
      <button type="button" class="btn btn-info me-2">Info</button>
      <button type="button" class="btn btn-dark me-2">Dark</button>
    </div>
    <div class="mt-3">
      <button type="button" class="btn btn-lg btn-primary me-2">Primary</button>
      <button type="button" class="btn btn-lg btn-secondary me-2">Secondary</button>
      <button type="button" class="btn btn-lg btn-success me-2">Success</button>
      <button type="button" class="btn btn-lg btn-danger me-2">Danger</button>
      <button type="button" class="btn btn-lg btn-warning me-2">Warning</button>
      <button type="button" class="btn btn-lg btn-info me-2">Info</button>
      <button type="button" class="btn btn-lg btn-dark me-2">Dark</button>
    </div>
    <div class="mt-3">
      <div class="btn-wrapper">
        <button type="button" class="btn btn-lg btn-primary me-2">Primary</button>
        <div class="mt-3">
          Helper text
        </div>
      </div>
    </div>

    <div class="h1 mt-4 fw-bolder">Panels</div>
    <div class="d-flex">
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <div class="card-text">
            <ul class="list-style-none text-center p-0">
              <li>Inventory:</li>
              <li>Hardware model</li>
              <li>Serial</li>
              <li>Firmware ver</li>
              <li>CPU, RAM. Flash</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card ms-2">
        <div class="card-body">
          <div class="card-text">
            <ul class="level-first p-0">
              <li>Controller info:</li>
              <li>
                <ul class="level-second">
                  <li>CPU: x86_64:</li>
                </ul>
                <ul class="level-second ms-1">
                  <li>OS: Ubuntu 22.04.3 LTS</li>
                  <li>Hostname: srvts3</li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card ms-2 card-success">
        <div class="card-body">
          <div class="card-text">
            CPUs status:
            <ul class="level-first p-0">
              <li>Inserted: 56</li>
              <li>Powered: 56</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card ms-2 card-secondary">
        <div class="card-body">
          <div class="card-text">
            CPUs status:
            <ul class="level-first p-0">
              <li>Inserted: 56</li>
              <li>Powered: 56</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card ms-2 card-danger">
        <div class="card-body">
          <div class="card-text">
            CPUs status:
            <ul class="level-first p-0">
              <li>Inserted: 56</li>
              <li>Powered: 54</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="card mt-2" style="width: 15rem;">
      <div class="card-body">
        <div class="card-text fw-semibold">
          Summary devices:
          <ul class="level-first p-0 ps-2">
            <li>Motherboards: 2</li>
            <li>Carrierboards: 14</li>
            <li>CPUs: 56</li>
            <li>PSUs: 3</li>
          </ul>
        </div>
        <div class="btn-wrapper w-100 ps-3 pe-3">
          <button type="button" class="btn btn-primary w-100">Inventory now</button>
          <div class="mt-2 bg-light-gray text-center">
            UPD: 24.02.2022 3:43AM
          </div>
        </div>
      </div>
    </div>


    <div class="h1 mt-4 fw-bolder">Forms</div>

    <div class="row mb-2">
      <div class="col">
        <input-text-component
          name="inputName"
          label="Enter Login"
          placeholder="login"
          help="Helpers"
        ></input-text-component>
      </div>
      <div class="col">
        <input-text-component
          name="inputName"
          label="Email address (disabled)"
          placeholder="name@example.com"
          :disabled="true"
        ></input-text-component>
      </div>
      <div class="col">
        <input-text-component
          name="inputName"
          label="Email address (readonly)"
          placeholder="name@example.com"
          :readonly="true"
        ></input-text-component>
      </div>
      <div class="col">
        <input-text-component
          name="inputName"
          label="Email address"
          placeholder="name@example.com"
          error="Please enter a message in the input."
        ></input-text-component>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col">
        <textarea-component
          label="Textarea"
          name="textarea"
          placeholder="Required example textarea"
          :required="true"
          help="Helper text"
          :resize="false"
        ></textarea-component>
      </div>
      <div class="col">
        <textarea-component
          label="Textarea Disabled"
          name="textarea"
          placeholder="Required example textarea"
          :disabled="true"
        ></textarea-component>
      </div>
      <div class="col">
        <textarea-component
          label="Textarea Readonly"
          name="textarea"
          placeholder="Required example textarea"
          :readonly="true"
        ></textarea-component>
      </div>
      <div class="col">
        <textarea-component
          label="Textarea Readonly"
          name="textarea"
          placeholder="Required example textarea"
          error="Please enter a message in the textarea."
        ></textarea-component>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="mb-3">
          <label for="formFile" class="form-label">Default file input example</label>
          <input class="form-control" type="file" id="formFile">
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Multiple files input example</label>
          <input class="form-control" type="file" id="formFileMultiple" multiple>
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label for="formFileDisabled" class="form-label">Disabled file input example</label>
          <input class="form-control" type="file" id="formFileDisabled" disabled>
        </div>
      </div>
    </div>
    <div class="h4">Select example</div>
    <div class="row">
      <div class="col">
        <select-component
          name="select1"
          label="Select from list"
          v-model="selectedValue"
          :options="selectOptions"
          help="Helper text"
        ></select-component>
      </div>
      <div class="col">
        <select-component
          name="select1"
          label="Select from list"
          v-model="selectedValue"
          :options="selectOptions"
          :disabled="true"
        ></select-component>
      </div>
      <div class="col">
        <select-component
          name="select1"
          label="Select from list"
          v-model="selectedValue"
          :default-nothing="true"
          :options="selectOptions"
          error="Select from list"
        ></select-component>
      </div>
    </div>

    <div class="mt-4">
      <h3>Checkboxes</h3>

      <div class="row">
        <div class="col">
          <checkbox-component
            name="flexCheckDefault"
            label="Default checkbox"
          ></checkbox-component>

          <checkbox-component
            name="flexCheckDefault2"
            label="Checked checkbox"
            v-model="checked"
          ></checkbox-component>

          <checkbox-component
            name="flexCheckDefault3"
            label="Checked checkbox"
            v-model="checked"
            help="Help text"
          ></checkbox-component>

          <checkbox-component
            name="flexCheckDefault4"
            label="Checked checkbox"
            v-model="checked"
            error="Please enter a message in the textarea."
          ></checkbox-component>

          <checkbox-component
            name="flexCheckDisabled"
            label="Disabled checkbox"
            disabled
            v-model="checked"
          ></checkbox-component>

          <checkbox-component
            name="flexCheckDisabled2"
            label="Disabled checkbox"
            disabled
          ></checkbox-component>
        </div>

        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
              Default radio
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
              Default checked radio
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input is-invalid" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
            <label class="form-check-label" for="flexRadioDefault3">
              Default radio
            </label>
            <div class="invalid-feedback">Please enter a message in the textarea.</div>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled>
            <label class="form-check-label" for="flexRadioDisabled">
              Disabled radio
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled>
            <label class="form-check-label" for="flexRadioCheckedDisabled">
              Disabled checked radio
            </label>
          </div>
        </div>

      </div>
    </div>

    <div class="mt-4 mb-4">
      <div class="h1 fw-bolder mb-3">Modals</div>


      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Modal
      </button>

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pb-0 text-center">
              <p>
                CPU will be shutdown! Connection will lost.<br>
                Are you sure?
              </p>
            </div>
            <div class="modal-footer justify-content-center pb-4">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
              <button type="button" class="btn btn-success ms-4">YES</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script lang="ts" setup>
import CheckboxComponent from "@/components/Forms/CheckboxComponent.vue";
import SelectComponent from "@/components/Forms/SelectComponent.vue";
import TextareaComponent from "@/components/Forms/TextareaComponent.vue";
import InputTextComponent from "@/components/Forms/InputTextComponent.vue";
import {ref} from "vue";
import AdminLayout from "@/views/Layout/AdminLayout.vue";

const checked = ref(true)
const selectedValue = ref('');
const selectOptions = ref([
  {name: 'Test1', id: 1},
  {name: 'Test2', id: 2},
  {name: 'Test3', id: 3}
])
</script>
